FROM node:lts as build

WORKDIR /client

COPY ./client/ /client

RUN npm install

ENV PATH /client/node_modules/.bin:$PATH

CMD npm run start

EXPOSE 3000

