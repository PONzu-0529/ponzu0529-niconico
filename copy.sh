#!/bin/sh

# Copy .devcontainer
cp .devcontainer/devcontainer.json default/.devcontainer/
cp .devcontainer/.env default/.devcontainer/
cp mariadb/0_init.sql default/mariadb/0_init.sql
cp mariadb/9_grant.sql default/mariadb/9_grant.sql

# Setup .env
TARGET_FILE="default/.devcontainer/.env"
sed -ri -e "s!LOCAL_HOST_PATH=.*!LOCAL_HOST_PATH=!g" default/.devcontainer/.env
sed -ri -e "s!DB_NAME=.*!DB_NAME=!g" $TARGET_FILE
sed -ri -e "s!DB_USER=.*!DB_USER=!g" default/.devcontainer/.env
sed -ri -e "s!DB_PASSWORD=.*!DB_PASSWORD=!g" default/.devcontainer/.env
sed -ri -e "s!DB_ROOT_PASSWORD=.*!DB_ROOT_PASSWORD=!g" default/.devcontainer/.env
sed -ri -e "s!USERNAME=.*!USERNAME=!g" default/.devcontainer/.env
sed -ri -e "s!XSERVER_ID=.*!XSERVER_ID=!g" default/.devcontainer/.env
sed -ri -e "s!XSERVER_DOMAIN=.*!XSERVER_DOMAIN=!g" default/.devcontainer/.env
sed -ri -e "s!XSERVER_SUBDOMAIN=.*!XSERVER_SUBDOMAIN=!g" default/.devcontainer/.env

# Setup .devcontainer.json
sed -ri -e "s!\"remoteUser\": \".*\"!\"remoteUser\": \"USER_NAME\"!g" default/.devcontainer/devcontainer.json
sed -ri -e "s!\"workspaceFolder\": \".*\"!\"workspaceFolder\": \"WORKSPACE_FOLDER\"!g" default/.devcontainer/devcontainer.json

# Setup init SQL
sed -ri -e "s!\`.*\`!\`DB_TABLE_NAME\`!g" default/mariadb/0_init.sql
sed -ri -e "s!'.*'@'%'!'DB_USER'@'%'!g" default/mariadb/9_grant.sql
