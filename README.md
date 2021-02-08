# log-data-output-decorator

[![License](https://img.shields.io/github/license/imponeer/log-data-output-decorator.svg)](LICENSE)
[![GitHub release](https://img.shields.io/github/release/imponeer/log-data-output-decorator.svg)](https://github.com/imponeer/log-data-output-decorator/releases) [![Maintainability](https://api.codeclimate.com/v1/badges/3e11a2969204f2abc7cf/maintainability)](https://codeclimate.com/github/imponeer/log-data-output-decorator/maintainability) [![PHP](https://img.shields.io/packagist/php-v/imponeer/log-data-output-decorator.svg)](http://php.net) 
[![Packagist](https://img.shields.io/packagist/dm/imponeer/log-data-output-decorator.svg)](https://packagist.org/packages/imponeer/log-data-output-decorator)

# Smarty DB resource

Small decorator that extends [Symfony OutputInterface](https://github.com/symfony/console/blob/5.x/Output/OutputInterface.php) delivered class with few options for easier to log data.

## Installation

To install and use this package, we recommend to use [Composer](https://getcomposer.org):

```bash
composer require imponeer/log-data-output-decorator
```

Otherwise, you need to include manually files from `src/` directory. 

## Usage example

```php
$output = new \Imponeer\Decorators\LogDataOutput\OutputDecorator(
   new \Symfony\Component\Console\Output\BufferedOutput();
);
$output->info('test');
$output->incrIndent();
$output->info('#1');
$output->info('#2');
``

## Using from templates

To use this resource from templates, you need to use `db:` prefix when accessing files. For example :
```smarty
  {include file="db:/images/image.tpl"}
```

## How to contribute?

If you want to add some functionality or fix bugs, you can fork, change and create pull request. If you not sure how this works, try [interactive GitHub tutorial](https://try.github.io).

If you found any bug or have some questions, use [issues tab](https://github.com/imponeer/log-data-output-decorator/issues) and write there your questions.