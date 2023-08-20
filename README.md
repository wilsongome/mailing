<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Sobre a aplicação
Trata-se de uma aplicação para disparos de e-mails totalmente personalizadas, dada uma lista de contatos em arquivo .CSV.

#Instruções

A aplicação está configurada no docker, então para executar basta seguir os seguintes passos:

#### 1: Exuctar o docker compose para subir os containers

``cd /dir/appdocker``
<br>
``docker compose up``
<br>
#### 2: Uma vez que os containers estejam inicados, configurar a aplicação
``docker exec app composer install``
<br>
``docker exec app php artisan key:generate``
<br>
``docker exec app php artisan migrate``
<br>
``docker exec app php artisan db:seed``
<br>
#### 3: Aplicação está configurada para executar na porta 8080, logo, acessar:<br>
<a href="http://localhost:8080">http://localhost:8080</a>
<br>
Todos os serviços, estão com suas portas mapeadas e acessíveis ao HOST. Basta verificar, e caso necessite, alterar no arquivo docker-compose.yml

### Tecnologias utilizadas

<ul>
<li>PHP 8.2</li>
<li>Laravel 10</li>
<li>MySQL</li>
<li>REDIS</li>
<li>Docker</li>
<li>Bootstrap 4</li>
</ul>
