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

## Install

To install through Composer, by run the following command:

```bash
composer require savannabits/acacia
```

The package will automatically register its service providers.
Then install the necessary files for code generation and backend rendering:

```bash
php artisan acacia:install
```

### Auto-loading

By default, the Acacia's classes are not loaded automatically.
You can autoload your modules using `psr-4` by adding the following to composer.json:

``` json
{
  "autoload": {
    "psr-4": {
      "App\\": "app/",
      "Acacia\\": "acacia/"
    }
  }
}
```

**Tip: don't forget to run `composer dump-autoload` afterwards.**

From here, you are ready to generate code and interact with your new backend.

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
