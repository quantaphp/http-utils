<?php

declare(strict_types=1);

namespace Quanta\Http;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class Stack implements RequestHandlerInterface
{
    /**
     * @var \Psr\Http\Server\RequestHandlerInterface
     */
    private RequestHandlerInterface $handler;

    /**
     * @var \Psr\Http\Server\MiddlewareInterface
     */
    private MiddlewareInterface $middleware;

    /**
     * @param \Psr\Http\Server\RequestHandlerInterface  $handler
     * @param \Psr\Http\Server\MiddlewareInterface      $middleware
     */
    public function __construct(RequestHandlerInterface $handler, MiddlewareInterface $middleware)
    {
        $this->handler = $handler;
        $this->middleware = $middleware;
    }

    /**
     * @inheritdoc
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return $this->middleware->process($request, $this->handler);
    }
}
