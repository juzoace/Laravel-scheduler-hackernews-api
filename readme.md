
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
    