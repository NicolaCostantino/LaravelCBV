[![Build Status](https://travis-ci.com/NicolaCostantino/LaravelCBV.svg?branch=master)](https://travis-ci.com/NicolaCostantino/LaravelCBV)
[![codecov](https://codecov.io/gh/NicolaCostantino/LaravelCBV/branch/master/graph/badge.svg)](https://codecov.io/gh/NicolaCostantino/LaravelCBV)


# LaravelCBV

A package for [Laravel](https://laravel.com/) implementing [Django](https://www.djangoproject.com/)'s [Class-Based Views](https://docs.djangoproject.com/en/dev/topics/class-based-views/) (CBV).  

It keeps a 1:1 mapping with Django 2.0 codebase, behavior and naming while using [Laravel](https://laravel.com/)'s native features.

## Table of Contents

* **[Setup](#setup)**
  * [PHP](#setup-php)
  * [Laravel](#setup-laravel)
  * [Requirements](#setup-requirements)
* **[Usage](#usage)**
  * [Example](#usage-example)
* **[Development](#development)**
  * [General](#development-general)
  * [Code](#development-code)
  * [Setup](#development-setup)
  * [Testing](#development-testing)
* **[Contributing](#contributing)**
* **[Author](#author)**
* **[License](#license)**
* **[Acknowledgments](#acknowledgments)**
  * [Inspiration](#inspiration)

## Setup <a name="setup"></a>

### PHP <a name="setup-php"></a>
Tested and developed on version: 7.2.*  

### Laravel <a name="setup-laravel"></a>
Tested and developed on version: 5.8.*  

### Requirements <a name="setup-requirements"></a>
Use [Composer](https://getcomposer.org/) to install the requirements needed
```bash
composer install
```

## Usage <a name="usage"></a>
The class `View` (which is the base class for the others CBVs) extends [Illuminate's Controller](https://laravel.com/api/master/Illuminate/Routing/Controller.html).  

Any LaravelCBV can be used as a common [Laravel](https://laravel.com/) controller while inheriting all the very same feature of the corresponding [Django](https://www.djangoproject.com/)'s [Class-Based Views](https://docs.djangoproject.com/en/dev/topics/class-based-views/).

## Development <a name="development"></a>

### General <a name="development-general"></a>
All the needed commands are listed as [GNU `make`](https://www.gnu.org/software/make/) target rules in the [Makefile](Makefile) file.  
Each subfolder could contain a local Makefile file, if needed.

### Code <a name="development-code"></a>
The source code is hosted on [GitHub](https://github.com/NicolaCostantino/LaravelCBV).

### Setup <a name="development-setup"></a>
Use [Composer](https://getcomposer.org/) to install also the requirements for development and testing (Composer's default behavior)
```bash
composer install
```
or use the `make` rule:
```bash
make develop
```

### Testing <a name="development-testing"></a>
Tests are executed using [PHPUnit](https://phpunit.de/) also for coverage.  

[Orchestral Testbench](https://github.com/orchestral/testbench) is used as support for testing the behavior of the package in a Laravel project.  

Additional Integration and End-To-End tests can be done using an host Laravel project and local test cases.

## Contributing <a name="contributing"></a>
Pull requests are welcome!  

For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## Author <a name="author"></a>
[Nicola Costantino](https://github.com/NicolaCostantino)  

## License <a name="license"></a>
[MIT](https://choosealicense.com/licenses/mit/) as listed in [LICENSE file](LICENSE)  
Copyright (c) 2019 Nicola Costantino