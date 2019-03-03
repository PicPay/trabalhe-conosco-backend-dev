# Geral
No Docker Toolbox (Windows 10 HOME) e no Ubuntu 18.04, precisei rodar esse comando na docker-machine, pois o elasticsearch não conseguiu subir.
sudo sysctl -w vm.max_map_count=262144

A base de dados será baixado durante o build do Docker.

O codigo fonte do FrontEnd esta na pasta front e o do BackEnd está na basta api.

**ANTES DE INICIAR** verifica qual é o padrão de "final de linha" do arquivo php/init/, pois estava tendo problema com isso, porque meu git
troca de lf para crlf, quando eu clono o repositorio, esse problema aconteceu somento no Windows 10.

Testei a aplicação no Windows 10 Home (virtualbox), Windows 10 PRO (Hyper-V) e Ubuntu 18.04.

# BackEnd
O BackEnd (API) irá ficar tentado conectar ao ElasticSearch quando vc subir o container,
pois ele sobe muito mais rapido que o Elastic e enquanto ele fica tentado conectar,
ele ficará imprimindo "Failed connect, try again". Isso você pode ignorar, pois 
enquanto o Elastic não subir, ele ficará nesse loop.

Quando ele imprimir lista1 ou lista2 significa que ele achou uma entrada que está
na lista de relevância, logo ele atribuirá um peso para essas entradas.

Coloquei 1G de memória para o php durante a importação do csv, para diminuir o volume de request ao Elastic
e tentar conseguir um desenpenho melhor, logo ele importa em blocos de 100 mil registros. Com 1G ele conseguia
subir ate 700 mil registros para a memória antes de estoura-la, então considerei 100 mil como uma escolha segura. 

Voce não precisa da keywork completa para fazer uma busca ex: se voce quer buscar por "debora", digitando apenas
"debo" já ira aparecer palavras que comecem com "debo"

# FrontEnd
Estará disponível em http://localhost/ ou no endereço do docker-machine.

O FrontEnd informa o estado do banco (not ready|importing(realizando importação do
csv)|ready), vc consegue fazer consultas durante a importação, porem pode acontecer
bugs.