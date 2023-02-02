#!/bin/sh

# Setup Appache rewrite_module
sudo a2enmod rewrite

# Setup DocumentRoot
sudo chmod 777 -R /home/${XSERVER_ID}/${XSERVER_DOMAIN}/public_html

# Setup Link
ln -s /home/${XSERVER_ID}/${XSERVER_DOMAIN}/repos/${XSERVER_SUBDOMAIN}/dist /home/${XSERVER_ID}/${XSERVER_DOMAIN}/public_html/${XSERVER_SUBDOMAIN}

# Change Owner
sudo chown -R 1000 /home/${XSERVER_ID}/${XSERVER_DOMAIN}/repos/${XSERVER_SUBDOMAIN}/node_modules
