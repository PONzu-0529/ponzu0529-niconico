#!/bin/sh

# setup appache rewrite_module
sudo a2enmod rewrite

# Change Owner
sudo chown -R 1000 /app/node_modules
sudo chown -R 1000 /app/php/vendor

# Install Packages
yarn
composer install
