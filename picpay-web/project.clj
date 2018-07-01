(defproject picpay-web "0.1.0"
  :description "Teste para candidatos ao time de backend dev."
  :dependencies [[org.clojure/clojure "1.9.0"]
                 [org.clojure/data.csv "0.1.4"]
                 [org.clojure/data.json "0.2.6"]
                 [org.clojure/core.async "0.4.474"]
                 [ring "1.7.0-RC1"] ;HTTP Server
                 [clucy "0.4.0"]]   ;Lucene Search
  :plugins [[lein-ring "0.12.4"]]
  :target-path "target/%s"
  :profiles {:uberjar {:aot :all}}
  :ring {:init com.picpay.core/init
         :handler com.picpay.core/handler})
