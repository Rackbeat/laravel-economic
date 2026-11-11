# Laravel e-conomic REST wrapper

<p align="center"> 
<a href="https://packagist.org/packages/LasseRafn/laravel-economic"><img src="https://img.shields.io/packagist/dt/LasseRafn/laravel-economic.svg?style=flat-square" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/LasseRafn/laravel-economic"><img src="https://img.shields.io/packagist/v/LasseRafn/laravel-economic.svg?style=flat-square" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/LasseRafn/laravel-economic"><img src="https://img.shields.io/packagist/l/LasseRafn/laravel-economic.svg?style=flat-square" alt="License"></a>
<a href="https://styleci.io/repos/75620408"><img src="https://styleci.io/repos/75620408/shield?branch=master" alt="StyleCI Status"></a>
</p>

## Requirements

| Package version | PHP    | Laravel |
|-----------------|--------|---------|
| 6.x             | ^8.3   | 13.x    |
| 5.x             | >=7.3  | 8.x, 9.x |

## Installation

1. Require using composer

``` bash
composer require rackbeat/laravel-economic
```

The service provider is auto-registered through Laravel package discovery.

2. Copy the package config to your local config with the publish command: 

``` bash
php artisan vendor:publish --provider="LasseRafn\Economic\EconomicServiceProvider"
```

## Usage outside of Laravel
You can use this package without Laravel, but configuration files wont be used, so you must provide the keys to the class.

The wrapper uses the `config()` method in the Economic class if no keys are provided. But if you remember to provide keys, it should never be called. 

Otherwise register a global method for `config` until there's a framework agnostic version (coming eventually) 

## [Contributors](https://github.com/LasseRafn/laravel-economic/graphs/contributors)
