<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>



# Sistema de Facturación en Laravel
Sistema de Facturación en Laravel es un proyecto que te permite gestionar las facturas de tus clientes de forma fácil y segura. Lo creé como parte de mi aprendizaje de Laravel, el popular framework de PHP.

## Requisitos
Para instalar y usar este proyecto, necesitas tener lo siguiente:

- PHP 8.0 o superior
- Laravel 10.x o superior
- Composer
- POSTGRESQL o cualquier otro sistema de gestión de bases de datos compatible con Laravel

Puedes consultar la [documentación oficial de Laravel](^1^) para más información sobre cómo instalar y configurar Laravel.

## Instalación
Para instalar este proyecto en tu entorno local, sigue estos pasos:

- Clona este repositorio: 
    // git clone https://github.com/Jeanniert/billingApis.git

- abrimos el proyecto: 
    //cd billingApis

- Instala las dependencias: 
    //composer install

- Crea un archivo .env y copia el contenido del archivo .env.example:
    //cp .env.example .env

- Genera la clave de la aplicación:
    //php artisan key:generate

- Configura la conexión a la base de datos en el archivo .env, indicando el nombre, el usuario, la contraseña y el puerto de tu base de datos.

- Migra la base de datos:
    //php artisan migrate:refresh --seed

- Ejecuta el servidor:
    //php artisan serve

- Abre http://localhost:8000 o en su defecto http://127.0.0.1:8000
