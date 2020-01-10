# Laravel Lumen API Demo

_2020-1-8 by Brendan Hart for Aligent Consulting_

Simple project to demonstrate ability to implement a simple Web API server for date calculations.

## Server Requirements

This project was developed on the following environment:
- CentOS Linux release 7.7.1908
- PHP 7.2.26
- Extra PHP Modules: php-zip, php-mbstring, php-pecl-openssl 
- Composer already available

However, it should be executable on any recent Linux with PHP >=7.2 (and those extra modules).

## How to run

**To run and test on localhost:**

1. Clone the project from Github
1. Change directory to `<install root>/laravel-lumen-api-demo`
1. Run `php composer.phar install` to pull down the dependencies
1. Clone the `.env.exmaple` file to `.env` and configure a random "APP_KEY" value
1. Run the builtin php server to serve the application on localhost:8000 
    
    `php -S localhost:8000 -t public`

1. The API will be accessible on `http://localhost:8000/api/*`
1. A page with some notes and  samples to access the endpoints is located at the site root 

**To access "externally" you'll need to either:**
- setup a "proper" webserver (details left an an exercise for the reader)
 
OR

- first ensure the relevant port (8000?) is configured on the firewall to allow for external access (Centos uses iptables), and then run the php built-in server with a command something like this:

  `php -S <server ip address>:8000 -t public`


## Notes

This project uses the following open source components:
- Laravel Lumen (minimalist API framework)
- nesbot/Carbon (date/time manipulation package)
- albertcht/lumen-testing (includes many Laravel testing helpers that are missing from Lumen)
- Pure.io CSS framework

