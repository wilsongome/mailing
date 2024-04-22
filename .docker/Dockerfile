FROM php:8.2-apache

EXPOSE 8080

#Argumentos passados para o arquivo docker-compose.yml
ARG user=user1
ARG uid=1000

# Create um usuário de sistema para executar os comandos do composer e php artisan
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

WORKDIR /var/www/html

#Install PHP libs
RUN apt-get update && apt-get install -y \
        libpng-dev \
        zlib1g-dev \
        libxml2-dev \
        libzip-dev \
        libonig-dev \
        zip \
        curl \
        unzip \
    && docker-php-ext-configure gd \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install mysqli \
    && docker-php-ext-install zip \
    && docker-php-ext-install sockets \
    && docker-php-source delete

#Instala e configura o PHP XDEBUG
COPY .docker/90-xdebug.ini "${PHP_INI_DIR}/conf.d"
RUN pecl install xdebug
RUN docker-php-ext-enable xdebug
    
#Instala Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

#Configura apache
COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite

#Configura o PHP
COPY .docker/php.ini "${PHP_INI_DIR}"

#Configura permissões
RUN chown -R www-data:www-data /var/www/html 
