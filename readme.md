# Laravel + Vue CMS/CRUD App

This is a basic CMS/CRUD app written in Laravel and Vue by [Don Cadavona](http://doncadavona.com).

## Features

* Authentication
* Users Management

## Installation

Get the app:

* `git clone git@github.com:doncadavona/laravel-vue.git`

Run the following:

* `cd laravel-vue`

* `composer install`

* `php artisan key:generate`

* `cp .env.example .env` (*Then edit your new `.env`. Eg. `DB_DATABASE`*)

* `php artisan migrate --seed`

* `npm install`

* `npm run dev`

You may now serve the app, perhaps like so:

* `php artisan serve`

## Test

To run tests, run the following:

* `phpunit`

## Developer

[doncadavona.com](http://doncadavona.com)