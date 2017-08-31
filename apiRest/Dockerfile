FROM node:6

WORKDIR /app

ADD . /app

EXPOSE 3000

RUN npm install

RUN npm install mysql

CMD ["sh", "wait-for-mysql.sh"]
