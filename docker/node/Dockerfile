FROM node:15-alpine3.12 as main

LABEL maintainer="igoragapie@gmail.com"

FROM main as dev

ENV APP_DIR=/var/www/app

RUN set -ex \
	&& apk add --no-cache --virtual .persistent-deps \
		tini \
		nano \
		git \
		shadow \
		make \
		g++ \
		gcc \
		libgcc \
		libstdc++ \
		linux-headers \
		python2 \
		gnupg \
		curl

RUN set -ex \
	&& mkdir -p ${APP_DIR} \
	&& mkdir -p "/.npm" \
	&& chown node:node ${APP_DIR} \
	&& chown -R node:node "/.npm" \
    && chmod 777 ${APP_DIR} \
    && chmod 777 "/.npm"

# https://www.elastic.io/nodejs-as-pid-1-under-docker-images/
ENTRYPOINT ["tini", "-e", "143", "--"]

WORKDIR ${APP_DIR}

EXPOSE 3000