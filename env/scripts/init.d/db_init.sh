#!/bin/bash

. $(dirname $0)/include.sh

file_env 'POSTGRES_HOST' 'db'
file_env 'POSTGRES_PORT' '5432'

file_env 'POSTGRES_USER' 'postgres'
file_env 'POSTGRES_PASSWORD' 'postgres'
file_env 'POSTGRES_DB' "${POSTGRES_USER}"

file_env 'BOX_DB_USER' 'box'
file_env 'BOX_DB_PASS' 'box'
file_env 'BOX_DB_DB' "${BOX_DB_USER}"
file_env 'BOX_ADMIN_PASSWORD' 'admin'

export PGHOST=${POSTGRES_HOST}
export PGPORT=${POSTGRES_PORT}
export PGUSER=${POSTGRES_USER}
export PGPASS=${POSTGRES_PASSWORD}
export PGDATABASE=${POSTGRES_DB}

echo "${POSTGRES_HOST}:${POSTGRES_PORT}:${POSTGRES_DB}:${POSTGRES_USER}:${POSTGRES_PASSWORD}" > /tmp/pgpass

if ! php /var/www/html/setup/init_db.php; then
    exit 1
fi
if ! php /var/www/html/setup/init.php; then
    exit 1
fi