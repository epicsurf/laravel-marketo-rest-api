# Laravel 5 Marketo REST API Provider
[![Latest Stable Version](https://poser.pugx.org/infusionweb/laravel-marketo-rest-api/v/stable)](https://packagist.org/packages/infusionweb/laravel-marketo-rest-api) [![Total Downloads](https://poser.pugx.org/infusionweb/laravel-marketo-rest-api/downloads)](https://packagist.org/packages/infusionweb/laravel-marketo-rest-api) [![Latest Unstable Version](https://poser.pugx.org/infusionweb/laravel-marketo-rest-api/v/unstable)](https://packagist.org/packages/infusionweb/laravel-marketo-rest-api) [![License](https://poser.pugx.org/infusionweb/laravel-marketo-rest-api/license)](https://packagist.org/packages/infusionweb/laravel-marketo-rest-api)

## An enhanced wrapper for using Marketo REST API Client package in Laravel

This package provides a Laravel 5 service provider and facade for [dchesterton/marketo-rest-api](https://github.com/dchesterton/marketo-rest-api), which is a Composer package that serves as an "unofficial PHP client for the Marketo.com REST API."

When enabled and configured, this package allows a more convenient use of the *Marketo REST API Client* functionality, through a Laravel facade, as well as adding some configuration options for added ease of use.

## Installation

### Step 1: Composer

Via Composer command line:

```bash
$ composer require infusionweb/laravel-marketo-rest-api
```

Or add the package to your `composer.json`:

```json
{
    "require": {
        "infusionweb/laravel-marketo-rest-api": "~0.1.0"
    }
}
```

### Step 2: Register the Service Provider

Add the service provider to your `config/app.php`:

```php
'providers' => [
    //
    InfusionWeb\Laravel\Marketo\MarketoClientProvider::class,
];
```

### Step 3: Enable the Facade

Add the facade to your `config/app.php`:

```php
'aliases' => [
    //
    'Marketo' => InfusionWeb\Laravel\Marketo\MarketoClientFacade::class,
];
```

### Step 4: Publish the package config file

```bash
$ php artisan vendor:publish --provider="InfusionWeb\Laravel\Marketo\MarketoClientProvider"
```

You may now setup Marketo authentication and other preferences by editing the `config/marketo.php` file.

## Usage

### Simple case

```php
<?php

use Marketo;


```

For additional documentation, see the [original Marketo REST API Client documentation](https://github.com/dchesterton/marketo-rest-api/blob/master/README.md), as well as [Marketo's own REST API documentation](http://developers.marketo.com/documentation/rest/).

## Credits

- [Russell Keppner](https://github.com/rkeppner)
- [All Contributors](https://github.com/InfusionWeb/laravel-marketo-rest-api/contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
