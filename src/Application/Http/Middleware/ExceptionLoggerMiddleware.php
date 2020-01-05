<?php

declare(strict_types=1);

namespace Antidot\Logger\Application\Http\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;
use Throwable;
use function get_class;
use function json_encode;
use function sprintf;

class ExceptionLoggerMiddleware implements MiddlewareInterface
{
    private const UNEXPECTED_EXCEPTION_MESSAGE = 'Unexpected error occurred during %s exception message serialization.';
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            return $handler->handle($request);
        } catch (Throwable $exception) {
            $message = json_encode([
                'message' => $exception->getMessage(),
                'code' => $exception->getCode(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine()
            ]);
            $this->logger->error(
                $message
                    ? $message
                    : sprintf(self::UNEXPECTED_EXCEPTION_MESSAGE, get_class($exception))
            );

            throw $exception;
        }
    }
}
