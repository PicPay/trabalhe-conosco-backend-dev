(ns com.picpay.core
  (:require [ring.middleware.params :refer [wrap-params]]
            [ring.adapter.jetty :refer [run-jetty]]
            [ring.util.response :refer [response]]
            [clojure.core.async :as async]
            [clojure.string :as string]
            [clojure.data.json :as json]
            [clojure.data.csv :as csv]
            [clojure.java.io :as io]
            [clucy.core :as clucy])
  (:import [java.io BufferedReader]))

(def index (clucy/disk-index "resources/index")); 

(defn add-index
  [users]
  (binding [clucy/*content* false]
    (apply clucy/add index users)
    :done))

(defn build-index-lazy
  [file]
  (with-open [rdr (io/reader file)]
    (->> (csv/read-csv rdr)
         (map #(zipmap [:id :name :username] %))
         (map #(with-meta % {:id {:indexed false}}))
         (partition-all 100000)
         (#(doseq [users %]
             (add-index users))))))

(defn lines-reducible
  [^BufferedReader rdr]
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

(defn parse-file-reducible
  [file]
  (eduction (map #(string/split % #","))
            (lines-reducible (io/reader file))))

(defn build-index-transduce
  [file]
  (transduce (comp (mapcat parse-file-reducible)
                   (map #(zipmap [:id :name :username] %))
                   (map #(with-meta % {:id {:indexed false}}))
                   (partition-all 1000000)
                   (map add-index))
             (constantly nil)
             [file]))

(defn build-index-parallel
  [file]
  (async/<!!
   (async/pipeline
   (.availableProcessors (Runtime/getRuntime))        ;; Parallelism factor
   (async/chan (async/dropping-buffer 0))             ;; Output channel - /dev/null
   (comp (mapcat parse-file-reducible)                ;; Pipeline transducer
         (map #(zipmap [:id :name :username] %))
         (map #(with-meta % {:id {:indexed false}}))
         (partition-all 1000)
         (map add-index))
   (async/to-chan [file]))))

(defn make-comparator
  [file]
  (let [s (slurp file)
        ids (set (string/split-lines s))]
    (fn [id1 id2]
      (let [b1 (contains? ids id1)
            b2 (contains? ids id2)]
        (cond (and b1 (not b2)) -1
              (and (not b1) b2) 1
              :else 0)))))

(defn init []
  (when-not (.exists (.getDirectory index))
    ;start build users index
    ))

(defn handler [request]
  (response "Hello World"))
