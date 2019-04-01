<?php

declare(strict_types=1);

namespace Antidot\Logger\Container;

use Psr\Container\ContainerInterface;
use WShafer\PSR11MonoLog\MonologFactory as BaseFactory;

class MonologFactory extends BaseFactory
{
    public function __invoke(ContainerInterface $container, string $name = 'default')
    {
        self::$channelName = $name;
        return parent::__invoke($container);
    }
}
