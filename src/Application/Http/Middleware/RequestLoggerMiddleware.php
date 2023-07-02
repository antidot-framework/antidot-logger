<?php

declare(strict_types=1);

namespace Antidot\Logger\Application\Http\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;
use function get_class;
use function json_encode;
use function sprintf;

class RequestLoggerMiddleware implements MiddlewareInterface
{
    private const UNEXPECTED_REQUEST_MESSAGE = 'Unexpected error occurred during %s request message serialization.';
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $message = json_encode([
            'method' => $request->getMethod(),
            'target' => $request->getRequestTarget(),
            'headers' => $request->getHeaders(),
            'query-string' => $request->getQueryParams(),
            'body' => (string)$request->getBody()
        ]);

        $this->logger->debug(
            $message
                ?: sprintf(self::UNEXPECTED_REQUEST_MESSAGE, get_class($request))
        );

        return $handler->handle($request);
    }
}
