FROM mhart/alpine-node
RUN npm install -g nodemon
WORKDIR /app
COPY package.json /app
RUN npm install
COPY . /app
EXPOSE 8081
