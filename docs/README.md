Logger Middleware
=================

Request and Exception PSR-15 logger middleware:

* RequestLoggerMiddleware
* ExceptionLoggerMiddleware

## Installation

Require package with [composer package manager](https://getcomposer.org/download/).

````bash
composer require antidot-fw/logger
````

Add both Middleware to your Pipeline

````php
<?php
// with Antidot Framework, Zend Expressive or Zend Stratigility

$app->pipe(\Antidot\Logger\Application\Http\Middleware\ExceptionLoggerMiddleware::class);
$app->pipe(\Antidot\Logger\Application\Http\Middleware\RequestLoggerMiddleware::class);
````

### Using [Zend Config Aggregator](https://framework.zend.com/blog/2017-04-20-config-aggregator.html)

It installs the library automatically

### Using factory:

#### Config

See [wshafer/psr11-monolog](https://github.com/wshafer/psr11-monolog) for complete config reference, it allows using some different handlers

#### factory

````php
<?php

use Antidot\Logger\Container\MonologFactory;
use Psr\Log\LoggerInterface;

$factory = new MonologFactory();

$logger = $factory->__invoke($container);
$container->set(LoggerInterface::class, $logger);
````
