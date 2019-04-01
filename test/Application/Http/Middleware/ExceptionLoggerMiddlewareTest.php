<?php

declare(strict_types=1);

namespace AntidotTest\Logger\Application\Http\Middleware;

use Antidot\Logger\Application\Http\Middleware\ExceptionLoggerMiddleware;
use Exception;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;

class ExceptionLoggerMiddlewareTest extends TestCase
{
    const EXCEPTION_MESSAGE = 'Some Error message';
    /** @var LoggerInterface|\PHPUnit\Framework\MockObject\MockObject */
    private $logger;
    /** @var ServerRequestInterface|\PHPUnit\Framework\MockObject\MockObject */
    private $serverRequest;
    /** @var RequestHandlerInterface|\PHPUnit\Framework\MockObject\MockObject */
    private $requestHandler;
    /** @var \Psr\Http\Message\ResponseInterface */
    private $response;

    public function testItShouldDoNothingWhenRequestGoesRight(): void
    {
        $this->havingALogger();
        $this->givenAServerRequest();
        $this->givenARequestHandler();
        $this->whenRequestIsHandled();
        $this->thenARequestHandlerWillReturnValidResponse();
    }

    public function testItShouldLogExceptionMessageThenThrowException(): void
    {
        $this->shouldThrowException();
        $this->havingALogger();
        $this->givenAServerRequest();
        $this->givenARequestHandler();
        $this->loggerShouldLogException();
        $this->whenRequestFailedInsideHandler();
    }

    private function shouldThrowException(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage(self::EXCEPTION_MESSAGE);
    }

    private function havingALogger(): void
    {
        $this->logger = $this->createMock(LoggerInterface::class);
    }

    private function givenAServerRequest(): void
    {
        $this->serverRequest = $this->createMock(ServerRequestInterface::class);
    }

    private function givenARequestHandler(): void
    {
        $this->requestHandler = $this->createMock(RequestHandlerInterface::class);
    }

    private function loggerShouldLogException(): void
    {
        $this->logger
            ->expects($this->once())
            ->method('error')
            ->with($this->isJson())
        ;
    }

    private function whenRequestFailedInsideHandler(): void
    {
        $this->requestHandler
            ->expects($this->once())
            ->method('handle')
            ->with($this->serverRequest)
            ->willThrowException(new Exception(self::EXCEPTION_MESSAGE));

        $this->whenRequestIsHandled();
    }

    private function whenRequestIsHandled(): void
    {
        $loggerMiddleware = new ExceptionLoggerMiddleware($this->logger);

        $this->response = $loggerMiddleware->process($this->serverRequest, $this->requestHandler);
    }

    private function thenARequestHandlerWillReturnValidResponse(): void
    {
        $this->assertInstanceOf(ResponseInterface::class, $this->response);
    }
}
