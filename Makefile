.PHONY: help

# https://gist.github.com/rsperl/d2dfe88a520968fbc1f49db0a29345b9
# define standard colors
BLACK        := $(shell tput -Txterm setaf 0)
RED          := $(shell tput -Txterm setaf 1)
GREEN        := $(shell tput -Txterm setaf 2)
YELLOW       := $(shell tput -Txterm setaf 3)
LIGHTPURPLE  := $(shell tput -Txterm setaf 4)
PURPLE       := $(shell tput -Txterm setaf 5)
BLUE         := $(shell tput -Txterm setaf 6)
WHITE        := $(shell tput -Txterm setaf 7)
RESET        := $(shell tput -Txterm sgr0)

docker_image = webdevops/php:8.1-alpine
docker_dev_image = webdevops/php-dev:8.1-alpine

help:
	@echo 'This is a PHP 8.1 application. If you have it (and ${WHITE}composer${RESET}) installed locally, then simply run:'
	@echo '  ${GREEN}composer install${RESET}'
	@echo '  ${GREEN}composer run tests${RESET}'
	@echo ''
	@echo 'This Makefile has some options to run the application in ${WHITE}docker${RESET} if you do not have 8.1 locally.'
	@echo 'The ${WHITE}docker${RESET} image is ${LIGHTPURPLE}${docker_image}${RESET}'
	@echo ''
	@echo 'Usage: make [${BLUE}subcommand${RESET}]'
	@echo 'subcommands:'
	@echo '  ${GREEN}shell${RESET}    Mounts current ${WHITE}pwd${RESET} and starts ${WHITE}sh${RESET} session in a ${WHITE}docker${RESET} image'
	@echo '  ${GREEN}tests${RESET}    Mounts current ${WHITE}pwd${RESET} and runs ${WHITE}composer run tests${RESET} in a ${WHITE}docker${RESET} image'
	@echo '  ${GREEN}coverage${RESET} Mounts current ${WHITE}pwd${RESET} and runs ${WHITE}composer run coverage${RESET} in a ${WHITE}docker${RESET} image. ${YELLOW}NOTE: this uses an alternative image, ${LIGHTPURPLE}${docker_dev_image}${RESET}'

ephemeral_docker_args = --rm \
	--tty \
	--interactive \
	--user=$(shell id -u):$(shell id -g)

docker_run = docker run \
	${ephemeral_docker_args} \
	--volume="$(shell pwd):/src" \
	--workdir=/src

shell:
	@${docker_run} ${docker_image} bash

install:
	@${docker_run} ${docker_image} composer install

test:
	@${docker_run} ${docker_image} composer run tests

coverage:
	@${docker_run} --env XDEBUG_MODE=coverage ${docker_dev_image} composer run coverage
