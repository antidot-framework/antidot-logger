<?php

declare(strict_types=1);

namespace AntidotTest\Logger\Application\Http\Middleware;

use Antidot\Logger\Application\Http\Middleware\RequestLoggerMiddleware;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;

class RequestLoggerMiddlewareTest extends TestCase
{
    /** @var LoggerInterface|\PHPUnit\Framework\MockObject\MockObject */
    private $logger;
    /** @var ServerRequestInterface|\PHPUnit\Framework\MockObject\MockObject */
    private $serverRequest;
    /** @var RequestHandlerInterface|\PHPUnit\Framework\MockObject\MockObject */
    private $requestHandler;
    /** @var \Psr\Http\Message\ResponseInterface */
    private $response;

    public function testItShouldLogAllRequestsInDebugMode(): void
    {
        $this->havingALogger();
        $this->givenAServerRequest();
        $this->givenARequestHandler();
        $this->whenRequestIsHandled();
        $this->thenARequestHandlerWillReturnValidResponse();
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

    private function whenRequestIsHandled(): void
    {
        $this->logger
            ->expects($this->once())
            ->method('debug')
            ->with($this->isJson());

        $middleware = new RequestLoggerMiddleware($this->logger);
        $this->response = $middleware->process($this->serverRequest, $this->requestHandler);
    }

    private function thenARequestHandlerWillReturnValidResponse(): void
    {
        $this->assertInstanceOf(ResponseInterface::class, $this->response);
    }
}
