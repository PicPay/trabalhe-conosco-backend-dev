(ns com.picpay.www.core
  (:require [com.stuartsierra.component :as component]
            [ring.middleware.params :refer [wrap-params]]
            [ring.adapter.jetty :refer [run-jetty]]
            [ring.util.response :refer [not-found]]
            [compojure.core :refer [routes ANY]]
            [liberator.core :refer [defresource]]
            [clojure.java.io :as io]
            [clojure.string :as s]
            [clucy.core :as clucy])
  (:import [java.io BufferedReader]))

(def max-results 1000)

(def results-per-page 15)

(def max-pages (dec (int (/ max-results results-per-page))))

(defn get-users [index query page]
  (clucy/search index query max-results
                :page (min page max-pages)
                :results-per-page results-per-page))

(defresource users [index]
  :allowed-methods [:head :get]
  
  :malformed? (fn [{{{:strs [name page] :or {page "0"}} :params} :request}]
                (or (nil? name) (not-every? #(Character/isDigit %) page)))
  
  :available-media-types ["application/json"]
  
  :handle-ok (fn [{{{:strs [name page] :or {page "0"}} :params} :request}]
               (let [query (if (vector? name)
                             (s/join " " (for [n name] (str "name:" n)))
                             (str "name:" name " username:" name))]
                 (get-users index query (Integer/parseInt page)))))

(defn app [index]
  (routes (ANY "/" [] (users index))
          (ANY "*" [] (not-found "Resource not found."))))

(defn priority-set [file]
  (set (s/split-lines (slurp file))))

(defn reducible-lines [^BufferedReader rdr]
  (reify clojure.lang.IReduceInit
    (reduce [this f init]
      (try
        (loop [state init]
          (if (reduced? state)
            state
            (if-let [line (.readLine rdr)]
              (recur (f state line))
              state)))
        (finally (.close rdr))))))

(defn calc-boost [{id :id} priority]
  (cond ((get priority 0) id) 2.0
        ((get priority 1) id) 1.0
        :else 0.0))

(defrecord WebServer [port index]
  component/Lifecycle
  (start [this]
    (let [server (run-jetty (wrap-params (app index)) {:port port :join? false})
          high (priority-set (io/resource "lista_relevancia_1.txt"))
          normal (priority-set (io/resource "lista_relevancia_2.txt"))
          indexer (future
                    (transduce
                     (comp
                      (map #(s/split % #","))
                      (map #(zipmap [:id :name :username] %))
                      (map #(with-meta % {:name {:boost (calc-boost % [high normal])}}))
                      (partition-all 10000)
                      (map #(binding [clucy/*content* false]
                              (apply clucy/add index %))))
                     (fn
                       ([] nil)
                       ([_ _] (when-not (.isRunning server) (reduced nil)))
                       ([_] nil))
                     (reducible-lines (io/reader (io/resource "users.csv")))))]
      (assoc this :server server :indexer indexer)))
  
  (stop [this]
    (.stop (:server this))
    (.join (:server this))
    (deref (:indexer this))
    (assoc this :server nil :indexer nil)))

(defn new-server [port]
  (let [index (clucy/disk-index (System/getProperty "java.io.tmpdir"))]
    (map->WebServer {:port port :index index})))
