FROM php:7.4-apache

# define
ARG DOCUMENT_ROOT
ARG USERNAME
ARG USER_UID=1000
ARG USER_GID=$USER_UID

# install
RUN apt -y update && \
    apt -y upgrade && \
    curl -fsSL https://deb.nodesource.com/setup_16.x | bash - && \
    apt -y install sudo tzdata git wget nodejs && \
    npm install -g yarn

# setup composer
WORKDIR /var
RUN wget -O composer-setup.php https://getcomposer.org/installer && \
    php composer-setup.php --install-dir=/usr/local/bin --filename=composer && \
    composer self-update

# setup DocumentRoot, php.ini, extentions
RUN sed -ri -e "s!/var/www/html!${DOCUMENT_ROOT}!g" /etc/apache2/sites-available/*.conf && \
    sed -ri -e "s!/var/www/!${DOCUMENT_ROOT}!g" /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf && \
    mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini" && \
    sed -ri -e 's/;extension=mysqli/extension=mysqli/g' $PHP_INI_DIR/php.ini && \
    docker-php-ext-install mysqli

# add user
RUN useradd --uid ${USER_UID} --create-home --shell /bin/bash -G sudo,root ${USERNAME} && \
    echo '%sudo ALL=(ALL) NOPASSWD:ALL' >> /etc/sudoers

# setting setup.sh
COPY setup.sh /var/setup.sh
RUN chmod 700 /var/setup.sh && \
    chown ${USERNAME}:${USERNAME} /var/setup.sh

CMD sh /var/setup.sh && sudo sudo apache2-foreground
