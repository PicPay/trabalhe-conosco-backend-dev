FROM node:8-alpine
EXPOSE 8080
WORKDIR /usr/src/web
COPY package*.json ./
RUN npm i --silent
COPY . .
CMD ["npm", "start"]
