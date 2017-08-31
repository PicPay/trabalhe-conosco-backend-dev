FROM node:alpine
RUN npm install -g nodemon
WORKDIR /app
COPY package.json /app
COPY . .
RUN npm install --save
CMD ["node", "server.js"]
EXPOSE 8081
