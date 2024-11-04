#!/usr/bin/env bash
docker compose down \
    && docker compose up -d \
    && docker network connect symfony_cli_internal api_server \
    && docker compose exec server bash
