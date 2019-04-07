<?php

namespace Lit\Voltage\Tests;

use Lit\Voltage\BasicRouter;
use Lit\Voltage\RouteStubResolver;
use PHPUnit\Framework\TestCase;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\ServerRequestFactory;

class BasicRouterTest extends TestCase
{
    public function testSmoke()
    {
        $stubResolver = new RouteStubResolver();

        $notFound = self::createMock(RequestHandlerInterface::class);
        $actions = [];

        $router = new BasicRouter($stubResolver, $notFound);
        foreach (['get', 'post', 'patch', 'put', 'delete'] as $method) {
            $router->{$method}("/$method", $actions[$method] = self::createMock(RequestHandlerInterface::class));

            self::assertSame($actions[$method], $router->route(ServerRequestFactory::fromGlobals([
                'REQUEST_METHOD' => strtoupper($method),
                'REQUEST_URI' => 'http://example.com/' . $method,
            ])));
        }


        self::assertSame($notFound, $router->route(ServerRequestFactory::fromGlobals([
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI' => 'http://example.com/foo/bar',
        ])));
        self::assertSame($notFound, $router->route(ServerRequestFactory::fromGlobals([
            'REQUEST_METHOD' => 'POST',
            'REQUEST_URI' => 'http://example.com/get',
        ])));
    }
}
