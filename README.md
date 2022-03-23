# acacia

[![Latest Version on Packagist](https://img.shields.io/packagist/v/savannabits/acacia.svg?style=flat-square)](https://packagist.org/packages/savannabits/acacia)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/savannabits/acacia/main.svg?style=flat-square)](https://travis-ci.org/savannabits/acacia)
[![Total Downloads](https://img.shields.io/packagist/dt/savannabits/acacia.svg?style=flat-square)](https://packagist.org/packages/savannabits/acacia)


`savannabits/acacia` (an improved successor to `savannabits/jetstream-inertia-generator`) is a Backend Modular Code and CRUD generator for Laravel 9.
The code is generated in the following stack:
* Laravel ^9
* Inertia.js
* Laravel Breeze & Sanctum
* Vue.js ^3
* Tailwindcss ^3
* PrimeVue ^3.11
## Before Installation
Before you begin installation, you have to prepare your laravel app by installing the following:
1. Install and Configure Laravel Sanctum [Follow these Steps](https://laravel.com/docs/9.x/sanctum#installation)
2. Install and configure Laravel Breeze as the authentication package [Follow these steps](https://laravel.com/docs/9.x/starter-kits#laravel-breeze-installation)
3. Install and configure `spatie/laravel-permission`. [Follow these Steps](https://spatie.be/docs/laravel-permission/v5/installation-laravel)
4. Install and configure `laravel/scout`. By default, acacia will try to configure the basic `database` driver for scout during installation. [Follow Scout Installation steps](https://laravel.com/docs/9.x/scout#installation)

Now you are ready to install Acacia!
Don't worry, acacia will be installed as a separate modular component, with its own frontend assets and even compilation process using vite.js, all separate from your main app, allowing you to even mix two frontend stacks together!

## Install

To install through Composer, by run the following command:

```bash
composer require savannabits/acacia -W
```

By default, the Acacia's classes are not loaded automatically.
Before proceeding with installation, autoload the Acacia namespace and backend modules using `psr-4` by adding the following to your app's composer.json:

``` json
{
  "autoload": {
    "psr-4": {
        "App\\": "app/",
        "Database\\Factories\\": "database/factories/",
        "Database\\Seeders\\": "database/seeders/",
        "Acacia\\": "acacia/"
    }
  }
}
```
**Tip: don't forget to run `composer dump-autoload` afterwards.**

The package will automatically register its service providers.
Then install the necessary files for code generation and backend by running:

```bash
php artisan acacia:install
```
**Top: If you would like to force the replacement of existing Acacia files, add the --force option to the command above**
From here, you are ready to generate code and interact with your new backend.

## Acacia's Anatomy

## Preview & Documentation

See a Preview or sample of the backend that you will get using this package [HERE](https://acacia.savannabits.com/admin).

Username: `admin@savannabits.com`<br>
Password: `password`

You'll find installation instructions and full documentation on [https://acacia.savannabits.com/docs](https://acacia.savannabits.com/docs).

## Credits

- [Sam Maosa](https://github.com/coolsam726)
- [Savannabits Ltd](https://github.com/savannabits)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
