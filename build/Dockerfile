FROM node:8.9.3-wheezy

COPY ./*.tar.gz /opt

RUN cd /opt && \
    tar xf *.tar.gz && \
    cd bundle && \
    apk add --update --no-cache build-base python && \
    (cd programs/server && npm install) && \
    apk del build-base python && \
    rm /opt/*.tar.gz 
    
WORKDIR /opt/bundle
CMD ["node", "main.js"]