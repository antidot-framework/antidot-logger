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

### Using Zend Config Aggregator

[Zend Config Aggregator](https://framework.zend.com/blog/2017-04-20-config-aggregator.html) installs the library automatically

To use both middlewares in Zend Expressive you need to create factory classes

````php
<?php
// src/App/Container/ExceptionLoggerMiddlewareFactory.php

namespace App\Container;

use Antidot\Logger\Application\Http\Middleware\ExceptionLoggerMiddleware;
use Psr\Log\LoggerInterface;

class ExceptionLoggerMiddlewareFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new ExceptionLoggerMiddleware($container->get(LoggerInterface::class));
    }
}

````

````php
<?php
// src/App/Container/RequestLoggerMiddlewareFactory.php

namespace App\Container;

use Antidot\Logger\Application\Http\Middleware\RequestLoggerMiddleware;
use Psr\Log\LoggerInterface;

class RequestLoggerMiddlewareFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new RequestLoggerMiddleware($container->get(LoggerInterface::class));
    }
}

````

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
