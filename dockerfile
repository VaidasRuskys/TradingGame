FROM php:7.2.5-fpm
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN apt-get update && apt-get install -y git libpng-dev
RUN docker-php-ext-install zip && docker-php-ext-enable zip
RUN apt-get update && apt-get install -y libmcrypt-dev mysql-client && docker-php-ext-install pdo pdo_mysql

RUN  apt-get update \
  && apt-get install -y wget \
  && rm -rf /var/lib/apt/lists/*

RUN wget https://get.symfony.com/cli/installer -O - | bash \
  && mv /root/.symfony/bin/symfony /usr/local/bin/symfony

COPY ./code/ /var/www/html/trading_game/

RUN cd /var/www/html/trading_game \
   && composer install

EXPOSE 8000

VOLUME var/www/html/trading_game/

CMD cd /var/www/html/trading_game \
    && symfony server:start