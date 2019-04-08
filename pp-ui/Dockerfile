FROM node:11.13.0-alpine

RUN mkdir -p /opt/dev/pp-ui/src/
WORKDIR  /opt/dev/pp-ui/

ENV PATH ./pp-ui/src/node_modules/.bin:$PATH

EXPOSE 7710

COPY ./ /opt/dev/pp-ui/

RUN npm install --silent
RUN npm install react-scripts@1.1.1 -g --silent

CMD ["npm", "start"]