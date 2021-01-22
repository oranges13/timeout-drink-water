#!/bin/sh
set -e

echo "Deploying application ..."

    # Update codebase
    git fetch origin production
    git reset --hard origin/production

    # Install dependencies based on lock file
    php-7.4 ~/.php/composer/composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

    # Clear cache
    php-7.4 artisan cache:clear

echo "Application deployed!"
