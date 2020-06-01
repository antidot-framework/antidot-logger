<?php

declare(strict_types=1);

namespace Antidot\Logger\Container\Config;

use Antidot\Logger\Application\Http\Middleware\ExceptionLoggerMiddleware;
use Antidot\Logger\Application\Http\Middleware\RequestLoggerMiddleware;
use Antidot\Logger\Container\MonologFactory;
use Psr\Log\LoggerInterface;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'services' => [
                RequestLoggerMiddleware::class => RequestLoggerMiddleware::class,
                ExceptionLoggerMiddleware::class => ExceptionLoggerMiddleware::class,
            ],
            'factories' => [
                LoggerInterface::class => MonologFactory::class,
            ],
        ];
    }
}
