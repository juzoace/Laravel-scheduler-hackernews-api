## Laravel API Starter Kit


## Installation

To install the project you can use composer

```bash
composer create-project joselfonseca/laravel-api new-api
```

Modify the .env file to suit your needs

## Installation 

## Development mode
Ensure you have the following tools properly installed and setup. PHP, Composer, MySQL, Tableplus, Xampp

```
clone the github repository

Switch to develop branch

Create .env using sample.env

Move into the project folder by using the command: cd 'Laravel-scheduler-hackernews-api'

Install dependencies by using the command: composer install

Ensure database is properly connected according to sample.env 

Run database migration by using the command: php artisan migrate

Setup your task scheduler 

For windows users see here: https://www.youtube.com/watch?v=W7ammr0a6ls&t=511s

For mac users here: https://stillat.com/blog/2016/12/07/laravel-task-scheduling-running-the-task-scheduler

Ensure you have redis properly setup and running

Ensure you get cacert.pem from https://curl.se/docs/caextract.html

Add the cacert.pem file to "C:\Program Files\php-8.2.10" depending on your php version and location

Edit your php.ini file found in your Php directory e.g "C:\Program Files\php-8.2.10\phi.ini" and add curl.cainfo="C:/Program Files/php-8.2.10/cacert.pem" to the [curl] section to prevent any curl error

Start server by using the command: php artisan serve

Run this command to enable redis queue handling: php artisan queue:work redis

Run the task scheduler and check your database

```
    
```
APP_NAME=Laravel
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

LOG_CHANNEL=stack
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=

BROADCAST_DRIVER=log
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MEMCACHED_HOST=127.0.0.1

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=null
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=mt1

MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
```

When you have the .env with your database connection set up you can run your migrations

```bash
php artisan migrate
```
Then run `php artisan passport:install`

Run `php artisan db:seed` and you should have a new user with the roles and permissions set up

## Tests

Navigate to the project root and run `vendor/bin/phpunit` after installing all the composer dependencies and after the .env file was created.

## API documentation
The project uses API blueprint as API spec and [Aglio](https://github.com/danielgtaylor/aglio) to render the API docs, please install aglio and [merge-apib](https://github.com/ValeriaVG/merge-apib) in your machine and then you can run the following command to compile and render the API docs 
```bash
composer api-docs
```

## License

The Laravel API Starter kit is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
