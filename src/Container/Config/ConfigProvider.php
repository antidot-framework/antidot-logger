<?php

declare(strict_types=1);

namespace Antidot\Logger\Container\Config;

use Antidot\Logger\Application\Http\Middleware\ExceptionLoggerMiddleware;
use Antidot\Logger\Application\Http\Middleware\RequestLoggerMiddleware;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => [
                'invokables' => [
                    RequestLoggerMiddleware::class => RequestLoggerMiddleware::class,
                    ExceptionLoggerMiddleware::class => ExceptionLoggerMiddleware::class,
                ]
            ]
        ];
    }
}
