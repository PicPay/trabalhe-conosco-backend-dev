(defproject picpay-web "0.1.0"
  :description "Teste para candidatos ao time de backend dev."
  :dependencies [[org.clojure/clojure "1.9.0"]
                 [com.stuartsierra/component "0.3.2"]
                 [org.clojars.kostafey/clucy "0.5.5.0"]
                 [ring "1.7.0-RC1"]    ;HTTP Server
                 [liberator "0.15.1"]  ;HTTP Toolkit
                 [compojure "1.6.1"]]  ;Routing
  :main ^:skip-aot com.picpay.core
  :target-path "target/%s"
  :profiles {:uberjar {:aot :all}
             :dev {:source-paths ["dev"]
                   :dependencies [[com.stuartsierra/component.repl "0.2.0"]
                                  [org.clojure/tools.namespace "0.2.11"]]}
             :repl {:plugins [[cider/nrepl "0.3.0"]]}})
