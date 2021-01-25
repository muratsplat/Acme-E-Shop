[![Build Status](https://www.travis-ci.com/muratsplat/Acme-E-Shop.svg?branch=main)](https://www.travis-ci.com/muratsplat/Acme-E-Shop)
## Acme E-Shop Website :)

This project was created to review my PHP language knowledge. 
This is very simple web project as you can see. The latest Laravel and PHP features where tried to use.
## Requirements
* Docker
* PHP >= 8.0
* Composer Package Manager

## How to set up the project
Firstly you need Docker in your local to setup and run the application painless.
If you sure docker is running in your local, just follow example:
```shell
$ git clone git@github.com:muratsplat/Acme-E-Shop.git
$ cd Acme-E-Shop
$ composer install
$ ./vendor/bin/sail up
```
Installing new docker images and installing the dependencies can take long time.
It depends on you connection speed.

***Note: Composer package manager you should be ready to use! To install: https://getcomposer.org/download/*** 


## How to run DB migrations and seed data example
```shell
$ curl 'http://localhost/reset/and/seed' --compressed
{"migration":"ok","brandSeeder":"ok","productSeeder":"ok"}
```
If everything is ok, just click to http://localhost.


## How to access emails via Mailhog
Check out : http://localhost:8025/#


## Test CreditCard Example
* Card Number: **5555555555554444**
* CVV: 123
* Expire Date: 12-2022
* Card Holder Name: Lorem Ipsum

## Todo
* Write unit test by mocking objects
* Write functional test by using Laravel test features.
