Antidot Logger
==============

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/antidot-framework/antidot-logger/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/antidot-framework/antidot-logger/?branch=2.x.x)
[![Code Coverage](https://scrutinizer-ci.com/g/antidot-framework/antidot-logger/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/antidot-framework/antidot-logger/?branch=2.x.x)
[![Build Status](https://scrutinizer-ci.com/g/antidot-framework/antidot-logger/badges/build.png?b=master)](https://scrutinizer-ci.com/g/antidot-framework/antidot-logger/build-status/2.x.x)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/antidot-framework/antidot-logger/badges/code-intelligence.svg?b=2.x.x)](https://scrutinizer-ci.com/code-intelligence)
![Maintainability](https://api.codeclimate.com/v1/badges/dd5349c19f7991e3fa95/maintainability)

Application PSR-15 logger middleware:

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

To use both middlewares in Zend Expressive you need to create factory classes

````php
<?php
// src/App/Container/ExceptionLoggerMiddlewareFactory.php

namespace App\Container;

use Antidot\Logger\Application\Http\Middleware\ExceptionLoggerMiddleware;
use Psr\Container\ContainerInterface;
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
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

class RequestLoggerMiddlewareFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new RequestLoggerMiddleware($container->get(LoggerInterface::class));
    }
}

````
