USER_ID := $(shell id -u)
GROUP_ID := $(shell id -g)

.DEFAULT_GOAL := help

.PHONY: help
help:
	@awk 'BEGIN {FS = ":.*?## "}; /^[a-zA-Z-]+:.*?## .*$$/ {printf "\033[32m%-15s\033[0m %s\n", $$1, $$2}' Makefile | sort

.PHONY: up
up: ## Start containers
	USER_ID=$(USER_ID) GROUP_ID=$(GROUP_ID) docker-compose up -d

.PHONY: down
down: ## Stop containers
	USER_ID=$(USER_ID) GROUP_ID=$(GROUP_ID)  docker-compose down

.PHONY: restart
restart: ## Restart containers
	USER_ID=$(USER_ID) GROUP_ID=$(GROUP_ID)  docker-compose restart

.PHONY: fpm
fpm: ## Fpm bash
	@docker-compose exec -u $(USER_ID):$(GROUP_ID) fpm ash

.PHONY: fpm-root
fpm-root: ## Root fpm bash
	@docker-compose exec fpm ash

.PHONY: node
node: ## Node bash
	@docker-compose exec -u $(USER_ID):$(GROUP_ID) node ash

.PHONY: node-root
node-root: ## Root node bash
	@docker-compose exec node ash

.PHONY: install
install: ## Composer install
	@docker-compose exec -u $(USER_ID):$(GROUP_ID) fpm composer install