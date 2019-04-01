<?php

declare(strict_types=1);

namespace Antidot\Logger\Application\Http\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;

class RequestLoggerMiddleware implements MiddlewareInterface
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $this->logger->debug(\json_encode([
            'method' => $request->getMethod(),
            'target' => $request->getRequestTarget(),
            'headers' => $request->getHeaders(),
            'query-string' => $request->getQueryParams(),
            'body' => (string)$request->getBody()
        ]));

        return $handler->handle($request);
    }
}
