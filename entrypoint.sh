#!/bin/sh

# Ejecutar migraciones de Laravel
# php artisan migrate --force
# php artisan migrate --path=app/modules/user/infraestructure/database/migrations/0001_01_01_000000_create_users_table.php

# Ejecutar el comando original del contenedor
exec "$@"

# Ejecutar el servidor de Laravel
php artisan serve