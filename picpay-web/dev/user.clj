(ns user
  (:require [clojure.java.io :as io]
            [com.picpay.core :as core]))

(def comp1 (make-comparator "lista_relevancia_1.txt"))

;(sort-by :id comp1 [])

(defn go-lazy []
  (time (core/build-index-lazy (io/resource "users.csv"))))

(defn go-transduce []
  (time (core/build-index-transduce (io/resource "users.csv"))))

(defn go-parallel []
  (time (core/build-index-parallel (io/resource "users.csv"))))

;(clucy/search index "name:giselesaraiva username:giselesaraiva" n)
;(clucy/search index "name:gisele name:saraiva" n)
