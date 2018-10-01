FROM alpine:3.8

RUN apk --update add \
      npm

COPY ./ ./

RUN npm install
RUN npm run build
RUN npm install -g serve
RUN chmod +x /docker/start.sh

ENTRYPOINT ["/docker/start.sh"]