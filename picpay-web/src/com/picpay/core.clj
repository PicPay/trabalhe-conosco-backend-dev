(ns com.picpay.core
  (:require [com.stuartsierra.component :as component]
            [com.picpay.www.core :as www])
  (:gen-class))

(defn system [port]
  (component/system-map
   :server (www/new-server port)))

(defn -main [& args]
  (component/start
   (system (Integer/parseInt (System/getenv "PORT")))))
