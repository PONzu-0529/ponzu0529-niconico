#!/bin/sh

cp -r .devcontainer/ default/
cp -r .vscode/ default/
cp -r mariadb/ default/
cp home/php/config/Config.php cron/config/Config.php
cp cron/config/Config.php default/config/Config.php
