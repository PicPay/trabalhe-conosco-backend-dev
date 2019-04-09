FROM node:11.13.0-alpine

RUN mkdir -p /opt/dev/pp-ui/src/
WORKDIR  /opt/dev/pp-ui/

ENV PATH ./pp-ui/src/node_modules/.bin:$PATH

EXPOSE 7710
COPY ./pp-ui/package.json /opt/dev/pp-ui/package.json

COPY ./pp-ui /opt/dev/pp-ui/

RUN npm install --silent

CMD ["npm", "start"]