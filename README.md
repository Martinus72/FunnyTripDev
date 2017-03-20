# FunnyTrip

FunnyTrip is a school project. It's a carpooling website.

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

### Prerequisites

You must download and install [PHP](https://secure.php.net/manual/fr/install.php) (minimum PHP 5.3.9 version)

You must download and install [Symfony2](https://symfony.com/doc/2.8/setup.html)

You must download and install [Composer](https://getcomposer.org/download/)


### Installing

*Notice:* Create a new database named "FunnyTrip" for example. It's important because Composer will ask your database name.

Download ZIP or clone the FunnyTrip Project

```bash
$ git clone https://github.com/Martinus72/FunnyTripDev.git
```

Install and Configure with Composer

```bash
$ cd FunnyTripDev/
$ composer install
```

## Running

Run the server

```bash
$ cd FunnyTripDev/
$ php app/console server:run
```

Now you can access to your [127.0.0.1:8000](http://127.0.0.1:8000) and Enjoy !

## Built With

* [Symfony](https://symfony.com/) - The PHP framework
* [FOSUserBundle](https://github.com/FriendsOfSymfony/FOSUserBundle/) - The Bundle adds support for a database-backed user system
* [Petkopara/crud-generator-bundle ](https://packagist.org/packages/petkopara/crud-generator-bundle) - Bundle for CRUD generation
* [FeedBundle](https://github.com/eko/FeedBundle) - Bundle to build RSS feeds from your entities
* [Gmaps.js](https://github.com/hpneo/gmaps) - The easiest way to use Google Maps

## Authors

* **Camille Balança** - *Developer*
* **Martin Lourdelet** - *Developer*
* **Martin Levrard** - *Developer* - [MartinL](https://github.com/Martinus72)
