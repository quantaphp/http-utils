<?php

declare(strict_types=1);

namespace Quanta\Http;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

function stack(RequestHandlerInterface $handler, MiddlewareInterface ...$middleware): RequestHandlerInterface {
    return ($head = array_pop($middleware) ?? false)
        ? new Stack(stack($handler, ...$middleware), $head)
        : $handler;
}

function queue(RequestHandlerInterface $handler, MiddlewareInterface ...$middleware): RequestHandlerInterface {
    return ($head = array_shift($middleware) ?? false)
        ? new Stack(queue($handler, ...$middleware), $head)
        : $handler;
}
