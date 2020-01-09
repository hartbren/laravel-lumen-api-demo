# Laravel Lumen API Demo

_2020-1-8 by Brendan Hart for Aligent Consulting_

Simple project to demonstrate ability to implement a simple Web API server for date calculations.

## Server Requirements

This project was developed on the following environment:
- CentOS Linux release 7.7.1908
- PHP 7.2.26
- Extra PHP Modules: php-zip, php-mbstring, php-pecl-openssl 

However, it should be executable on any recent Linux with PHP >=7.2 (and those extra modules).

## How to run

After cloning the project from Github, change directory to 
the \[install root\]/laravel-lumen-api-demo folder and execute:

    php -S localhost:8000 -t public

The API will be accessible on http://localhost:8000

To access from an external system you'll need to either:
- setup a "proper" webserver (details left an an exercise for the reader) 
- first ensure the relevant port (8000?) is configured on the firewall to allow for external access (Centos uses iptables), and then run the php built-in server with a command something like this:


       php -S <server ip address>:8000 -t public


