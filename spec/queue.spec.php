<?php

declare(strict_types=1);

use function Eloquent\Phony\Kahlan\mock;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

use function Quanta\Http\queue;
use Quanta\Http\Stack;

describe('queue', function () {

    context('when no middleware is given', function () {

        it('should return the given request handler', function () {
            $handler = mock(RequestHandlerInterface::class);

            $test = queue($handler->get());

            expect($test)->toBe($handler->get());
        });

    });

    context('when at least one middleware is given', function () {

        it('should return a Stack reducing them in FIFO order', function () {
            $handler = mock(RequestHandlerInterface::class);
            $middleware1 = mock(MiddlewareInterface::class);
            $middleware2 = mock(MiddlewareInterface::class);
            $middleware3 = mock(MiddlewareInterface::class);

            $test = queue($handler->get(), $middleware1->get(), $middleware2->get(), $middleware3->get());

            $expected = new Stack(
                new Stack(
                    new Stack(
                        $handler->get(),
                        $middleware3->get(),
                    ),
                    $middleware2->get(),
                ),
                $middleware1->get(),
            );

            expect($test)->toEqual($expected);
        });

    });

});
