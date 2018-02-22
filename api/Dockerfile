FROM node:8-alpine
EXPOSE 8000
WORKDIR /usr/src/api
RUN apk --no-cache add --virtual builds-deps build-base python
COPY package*.json ./
RUN npm i --silent
RUN npm rebuild bcrypt --build-from-source
COPY . .
CMD ["npm", "start"]
