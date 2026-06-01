#!/bin/bash
set -e

cd /var/www/html

if [ ! -f .env ]; then
    cp .env.docker .env
fi

DB_HOST="${DB_HOST:-db}"
DB_PORT="${DB_PORT:-5432}"

echo "Aguardando o banco de dados em ${DB_HOST}:${DB_PORT}..."
until nc -z "${DB_HOST}" "${DB_PORT}"; do
    sleep 1
done
echo "Banco de dados disponível."

if ! grep -q '^APP_KEY=base64:' .env; then
    php artisan key:generate --force
fi

NEEDS_SEED=0
php artisan migrate:status >/dev/null 2>&1 || NEEDS_SEED=1

php artisan migrate --force

if [ "${NEEDS_SEED}" = "1" ]; then
    echo "Primeira execução: populando o banco de dados..."
    php artisan db:seed --force
fi

php artisan storage:link >/dev/null 2>&1 || true
php artisan config:clear

chown -R www-data:www-data storage bootstrap/cache

exec /usr/bin/supervisord -c /etc/supervisord.conf
