# Versao node 6
FROM node:6

# Adiciona todo conteudo do diretorio corrente a uma pasta app
ADD . /app

# Instala dependencias do projeto
RUN cd /app; \  
    npm install --production

# Server Port
EXPOSE 8123

# Roda o projeto
CMD ["node", "/app/index.js"]  
