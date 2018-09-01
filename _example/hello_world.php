<?php

use Lit\Core\Action;
use Lit\Core\App;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequestFactory;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;

// @codeCoverageIgnoreStart

/** @noinspection PhpIncludeInspection */
require(__DIR__ . '/../vendor/autoload.php');

class HelloAction extends Action
{
    public function __construct()
    {
        $factory = new class implements ResponseFactoryInterface
        {
            public function createResponse(int $code = 200, string $reasonPhrase = ''): ResponseInterface
            {
                return (new Response())->withStatus($code);
            }

        };
        $this->responseFactory = $factory;
    }

    protected function main(): ResponseInterface
    {
        return $this->json()->render([
            'hello' => 'world',
            'method' => $this->request->getMethod(),
            'uri' => $this->request->getUri()->__toString(),
        ]);
    }
}

$app = new App(new HelloAction());

$request = ServerRequestFactory::fromGlobals();
$response = $app->handle($request);
$emitter = new SapiEmitter();
$emitter->emit($response);

// @codeCoverageIgnoreEnd
