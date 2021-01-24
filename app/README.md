## Acme E-Shop Website :)

This project was created to review my PHP language knowledge. 
This is very simple web project as you can see. The latest Laravel and PHP features where tried to use.  

## How to set up the project
Firstly you need Docker in your local to setup and run the application painless.
If you sure docker is running in your local, just follow example:
```shell
$ git clone 

$ cd simple-ecommerce-php/app
$ ./vendor/bin/sail up
```
Installing new docker images and installing the dependencies can take long time.
It depends on you connection speed.

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
