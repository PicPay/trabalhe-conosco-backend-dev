FROM node

RUN useradd --user-group --create-home --shell /bin/false app

WORKDIR /home/app/frontend
COPY package.json /home/app/frontend/package.json
RUN npm install
COPY . /home/app/frontend
RUN chown -R app:app /home/app/frontend/*

USER app
WORKDIR /home/app/frontend

EXPOSE 9001

CMD ["npm", "run", "start"]
