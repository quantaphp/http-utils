<?php

declare(strict_types=1);

use function Eloquent\Phony\Kahlan\mock;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use Quanta\Http\Stack;

describe('Stack', function () {

    beforeEach(function () {
        $this->handler = mock(RequestHandlerInterface::class);
        $this->middleware = mock(MiddlewareInterface::class);

        $this->stack = new Stack($this->handler->get(), $this->middleware->get());
    });

    it('should implements RequestHandlerInterface', function () {
        expect($this->stack)->toBeAnInstanceOf(RequestHandlerInterface::class);
    });

    describe('->handle()', function () {

        it('should return the response produced by the middleware and the request handler', function () {
            $request = mock(ServerRequestInterface::class);
            $response = mock(ResponseInterface::class);

            $this->middleware->process->with($request, $this->handler)->returns($response);

            $test = $this->stack->handle($request->get());

            expect($test)->toBe($response->get());
        });

    });

});
