<?php

declare(strict_types=1);

namespace Lit\Voltage\Tests;

use Lit\Nimo\Tests\NimoTestCase;
use Lit\Voltage\AbstractAction;
use Lit\Voltage\App;
use Lit\Voltage\ThrowableResponse;
use PHPUnit\Framework\MockObject\MockObject;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;

class AppTest extends NimoTestCase
{
    public function testSmoke()
    {
        $response = new Response();
        $request = new ServerRequest();
        $request2 = new ServerRequest();

        $handler = $this->assertedHandler($request, $response, 'equal');
        $middleware = $this->assertedNoopMiddleware($request2, $request);
        $app = new App($handler, $middleware);
        $result = $app->handle($request2);

        self::assertSame($result, $response);
    }

    public function testThrow()
    {
        $response = new Response();
        $request = new ServerRequest();


        /** @var AbstractAction|MockObject $action */
        $action = $this->getMockForAbstractClass(AbstractAction::class);
        $action->method('main')
            ->with()
            ->willThrowException(ThrowableResponse::of($response));

        $app = new App($action);
        $result = $app->handle($request);

        self::assertSame($result, $response);
    }
}
