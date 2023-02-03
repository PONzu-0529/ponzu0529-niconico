#!/bin/sh

# Make mariadb 
if [ ! -d mariadb ]; then
    mkdir mariadb
fi

# Copy Default
cp -r default/.devcontainer ./
cp default/mariadb/* mariadb/
cp .env.example .env

# Setup Args
echo -n "USERNAME: "
read username

echo -n "DB PASSWORD: "
read password

local_host_path=`pwd`

echo -n "TABLE NAME: "
read table_name

echo -n "XSERVER ID: "
read xserver_id

echo -n "XSERVER DOMAIN: "
read xserver_domain

echo -n "XSERVER SUBDOMAIN: "
read xserver_subdomain

# Setup .env
sed -ri -e "s!APP_KEY=!APP_KEY=samplekeysamplekeysamplekeysampl!g" .env
sed -ri -e "s!DB_HOST=127.0.0.1!DB_HOST=mariadb!g" .env
sed -ri -e "s!DB_DATABASE=tmp!DB_DATABASE=${table_name}!g" .env
sed -ri -e "s!DB_USERNAME=root!DB_USERNAME=${username}!g" .env
sed -ri -e "s!DB_PASSWORD=!DB_PASSWORD=${password}!g" .env

# Setup .env in devcontainer
sed -ri -e "s!LOCAL_HOST_PATH=!LOCAL_HOST_PATH=${local_host_path}!g" .devcontainer/.env
sed -ri -e "s!DB_USER=!DB_USER=${username}!g" .devcontainer/.env
sed -ri -e "s!DB_PASSWORD=!DB_PASSWORD=${password}!g" .devcontainer/.env
sed -ri -e "s!DB_ROOT_PASSWORD=!DB_ROOT_PASSWORD=${password}!g" .devcontainer/.env
sed -ri -e "s!USERNAME=!USERNAME=${username}!g" .devcontainer/.env
sed -ri -e "s!XSERVER_ID=!XSERVER_ID=${xserver_id}!g" .devcontainer/.env
sed -ri -e "s!XSERVER_DOMAIN=!XSERVER_DOMAIN=${xserver_domain}!g" .devcontainer/.env
sed -ri -e "s!XSERVER_SUBDOMAIN=!XSERVER_SUBDOMAIN=${xserver_subdomain}!g" .devcontainer/.env

# Setup .devcontainer.json
sed -ri -e "s!\"remoteUser\": \"USER_NAME\"!\"remoteUser\": \"${username}\"!g" .devcontainer/devcontainer.json
sed -ri -e "s!\"workspaceFolder\": \"WORKSPACE_FOLDER\"!\"workspaceFolder\": \"/home/${xserver_id}/${xserver_domain}/repos/${xserver_subdomain}\"!g" .devcontainer/devcontainer.json

# Setup init SQL
sed -ri -e "s!\`DB_TABLE_NAME\`!\`${table_name}\`!g" mariadb/0_init.sql
sed -ri -e "s!'DB_USER'@'%'!'${username}'@'%'!g" mariadb/9_grant.sql
