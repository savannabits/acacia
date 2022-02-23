# Laravel-Modules

[![Latest Version on Packagist](https://img.shields.io/packagist/v/savannabits/acacia-generator.svg?style=flat-square)](https://packagist.org/packages/savannabits/acacia-generator)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/nWidart/acacia-generator/master.svg?style=flat-square)](https://travis-ci.org/nWidart/acacia-generator)
[![Scrutinizer Coverage](https://img.shields.io/scrutinizer/coverage/g/nWidart/acacia-generator.svg?maxAge=86400&style=flat-square)](https://scrutinizer-ci.com/g/nWidart/acacia-generator/?branch=master)
[![Quality Score](https://img.shields.io/scrutinizer/g/nWidart/acacia-generator.svg?style=flat-square)](https://scrutinizer-ci.com/g/nWidart/acacia-generator)
[![Total Downloads](https://img.shields.io/packagist/dt/savannabits/acacia-generator.svg?style=flat-square)](https://packagist.org/packages/savannabits/acacia-generator)

| **Laravel**  |  **acacia-generator** |
|---|---|
| 5.4  | ^1.0  |
| 5.5  | ^2.0  |
| 5.6  | ^3.0  |
| 5.7  | ^4.0  |
| 5.8  | ^5.0  |
| 6.0  | ^6.0  |
| 7.0  | ^7.0 |
| 8.0  | ^8.0 |

`savannabits/acacia-generator` is a Laravel package which created to manage your large Laravel app using modules. Module is like a Laravel package, it has some views, controllers or models. This package is supported and tested in Laravel 8.

This package is a re-published, re-organised and maintained version of [pingpong/modules](https://github.com/pingpong-labs/modules), which isn't maintained anymore. This package is used in [AsgardCMS](https://asgardcms.com/).

With one big added bonus that the original package didn't have: **tests**.

Find out why you should use this package in the article: [Writing modular applications with acacia-generator](https://nicolaswidart.com/blog/writing-modular-applications-with-acacia-generator).

## Install

To install through Composer, by run the following command:

``` bash
composer require savannabits/acacia-generator
```

The package will automatically register a service provider and alias.

Optionally, publish the package's configuration file by running:

``` bash
php artisan vendor:publish --provider="Savannabits\Modules\AcaciaGeneratorServiceProvider"
```

### Autoloading

By default, the module classes are not loaded automatically. You can autoload your modules using `psr-4`. For example:

``` json
{
  "autoload": {
    "psr-4": {
      "App\\": "app/",
      "Modules\\": "Modules/"
    }
  }
}
```

**Tip: don't forget to run `composer dump-autoload` afterwards.**

## Documentation

You'll find installation instructions and full documentation on [https://savannabits.com/acacia-generator/](https://savannabits.com/acacia-generator/).

## Credits

- [Nicolas Widart](https://github.com/savannabits)
- [gravitano](https://github.com/gravitano)
- [All Contributors](../../contributors)

## About Nicolas Widart

Nicolas Widart is a freelance web developer specialising on the Laravel framework. View all my packages [on my website](https://savannabits.com/), or visit [my website](https://nicolaswidart.com).


## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
