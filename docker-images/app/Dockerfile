FROM ubuntu:trusty

RUN DEBIAN_FRONTEND=noninteractive \
    apt-get update \
    && apt-get install -y \
        wget \
        curl \
        git

RUN curl -sL https://deb.nodesource.com/setup_6.x | sudo -E bash -
RUN apt-get install -y nodejs

WORKDIR /app

COPY bin/start.sh /start.sh

CMD [ "/start.sh" ]
