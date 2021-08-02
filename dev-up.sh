#!/usr/bin/env bash
set -euo pipefail

echo "--Copy env from dist--"
if [[ ! -f ./app/config/sites/er_glavbukh_ru/.env.local ]]; then
    cp ./app/config/sites/er_glavbukh_ru/.env.dist ./app/config/sites/er_glavbukh_ru/.env.local
fi
if [[ ! -f ./app/.env.local ]]; then
    cp ./app/.env.dist ./app/.env.local
fi
if [[ ! -f ./.env ]]; then
    cp ./.env.dist ./.env
fi

echo '--Docker-compose up--'
docker-compose up -d --build
echo '--Composer install--'
docker-compose exec app composer install
echo '--Applying migrations--'
docker-compose exec app bin/console doctrine:migrations:migrate -n
docker-compose exec test bin/console doctrine:migrations:migrate -n
echo '--Load fixtures on test database--'
docker-compose exec test bin/console doctrine:fixtures:load -n  --purge-with-truncate

docker-compose exec -T sphinx indexer --all
docker-compose exec -T sphinx searchd
