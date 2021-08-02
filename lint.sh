#!/usr/bin/env bash
set -euo pipefail

echo '---PHP lint---'
docker run --rm -v "${PWD}"/app/src/:/app nexus.action-media.ru/docker-action-base/base-service-php74-gost:latest bash -c "cd /app && find . -name \"*.php\" -print0 | xargs -0 -n1 -P8 php -l"

echo '---Yaml lint---'
docker run --rm -v "${PWD}":/app sdesbure/yamllint yamllint -c /app/.yamllint /app/

echo '---Static anaylyze---'
docker-compose exec app psalm --show-info=false
