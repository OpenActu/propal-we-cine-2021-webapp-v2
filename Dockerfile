FROM php:8.1-apache

ARG APT_ARGS="-qy"

# --- installation de composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN apt-get update -y && \
    apt-get install zip unzip
# --- installation de composer /

# --- installation de symfony
RUN apt-get update -y && \
    apt-get upgrade -y && \
    apt-get install ${APT_ARGS} wget git && \
    wget https://get.symfony.com/cli/installer -O - | bash && \
    mv /root/.symfony5/bin/symfony /usr/local/bin/symfony
# --- installation de symfony /

# --- configuration de php
RUN apt-get update -y && \
    apt-get install -y zlib1g-dev libicu-dev g++

RUN docker-php-ext-configure intl
RUN docker-php-ext-install intl
RUN docker-php-ext-install calendar && docker-php-ext-configure calendar
# --- configuration de php /

# --- extension zip
RUN apt-get install -y libzip-dev zip && docker-php-ext-install zip
# --- extension zip /

# --- divers
RUN apt-get install -y vim
# --- divers /

# --- installation de npm & yarn
ENV NODE_VERSION=18.16.1
RUN apt install -y curl
RUN curl -o- https://raw.githubusercontent.com/creationix/nvm/v0.34.0/install.sh | bash
ENV NVM_DIR=/root/.nvm
RUN . "$NVM_DIR/nvm.sh" && nvm install ${NODE_VERSION}
RUN . "$NVM_DIR/nvm.sh" && nvm use v${NODE_VERSION}
RUN . "$NVM_DIR/nvm.sh" && nvm alias default v${NODE_VERSION}
ENV PATH="/root/.nvm/versions/node/v${NODE_VERSION}/bin/:${PATH}"
RUN node --version
RUN npm --version
RUN npm install --global yarn
# --- installation de npm & yarn /
# --- installation de yarn
#RUN apt-get update && apt-get install -y gnupg && \
#    curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add - && \
#    echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list && \
#    apt-get install -y yarn
# --- installation de yarn /

RUN apt autoremove -y

COPY docker/php.ini "$PHP_INI_DIR/php.ini"
COPY docker/000-default.conf /etc/apache2/sites-available/000-default.conf

RUN a2ensite 000-default.conf && \
    service apache2 restart

###> storage right ###
RUN mkdir /data && \
    chown -R www-data:www-data /data
###< storage right ###

###> share right ###
RUN mkdir /share
###< share right ###

EXPOSE 80
WORKDIR /var/www/html
