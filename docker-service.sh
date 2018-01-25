#!/bin/bash

set -o nounset
set -o errexit

env=""
DEBUG=""

OPTIND=1

# Usage info
show_help() {
cat << EOF
Usage:  ${0##*/} [-e] [COMMAND]
Options:
  -e string        Specify env ("test"|"dev") (default "dev")

Commands:
  build            Build docker images
  start            Start docker containers
  stop             Stop docker containers
  down             Remove docker containers
  cc               Clear the symfony cache + generate composer autoload
  install          Run app installation scripts
  populate         Load data fixtures in app
  functionalTests  Run functional tests
EOF
}

build() {
#    cp -n .env.dist .env

    docker-compose build
}

start() {
    docker-compose -f docker-compose"$env".yml up -d
    sleep 1
    docker-compose -f docker-compose"$env".yml ps
}

install() {
    sleep 1
    docker-compose -f docker-compose"$env".yml exec -T --user www-data phpfpm composer install --prefer-dist --no-interaction --optimize-autoloader
#    docker-compose exec -T --user www-data phpfpm /usr/bin/env bin/console doctrine:database:drop --force
    docker-compose -f docker-compose"$env".yml exec -T --user www-data phpfpm /usr/bin/env bin/console doctrine:database:create --if-not-exists
    docker-compose -f docker-compose"$env".yml exec -T --user www-data phpfpm /usr/bin/env bin/console doctrine:schema:update --force
    docker-compose -f docker-compose"$env".yml exec -T --user www-data phpfpm /usr/bin/env bin/console cache:clear
    docker-compose -f docker-compose"$env".yml exec -T --user www-data phpfpm /usr/bin/env bin/console cache:warmup
}

populate() {
    docker-compose -f docker-compose"$env".yml exec -T --user www-data phpfpm /usr/bin/env bin/console doctrine:fixtures:load --no-interaction
}

cc() {
    docker-compose exec -f docker-compose"$env".yml -T --user www-data phpfpm /usr/bin/env bin/console cache:clear
    docker-compose exec -f docker-compose"$env".yml -T --user www-data phpfpm /usr/bin/env bin/console cache:warmup
    docker-compose exec -f docker-compose"$env".yml -T --user www-data phpfpm /usr/bin/env composer dumpautoload
}

stop() {
    docker-compose -f docker-compose"$env".yml stop
}

down() {
    docker-compose -f docker-compose"$env".yml down
}

while getopts "h:e:" opt; do
  case $opt in
    h)
        show_help
        exit 0
        ;;
    e)
        env=".$OPTARG"
        ;;
    *)
        show_help >&2
        exit 1
        ;;
  esac
done

# Shift off the options and optional --.
shift "$((OPTIND-1))"

case "$1" in
 build)
        build
        ;;
 start)
        start
        ;;
 stop)
        stop
        ;;
 down)
        down
        ;;
 restart)
        stop
        start
        ;;
 install)
        install
        ;;
 populate)
        populate
        ;;
 cc)
        cc
        ;;
 *)
        echo "Usage $0 {build|start|stop|down|install|populate|cc}"
        exit 1
esac

exit 0
