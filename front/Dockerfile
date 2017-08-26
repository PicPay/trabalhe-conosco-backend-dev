FROM mhart/alpine-node
RUN npm install -g node-gyp-install
RUN npm install -g @angular/cli
WORKDIR /app
COPY package.json /app
RUN npm install
COPY . /app
EXPOSE 4200
