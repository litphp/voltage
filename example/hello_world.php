<?php

use Interop\Http\Factory\ResponseFactoryInterface;
use Lit\Core\Action;
use Lit\Core\App;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response;
use Zend\Diactoros\Response\SapiEmitter;
use Zend\Diactoros\ServerRequestFactory;

require(__DIR__ . '/../vendor/autoload.php');

class HelloAction extends Action
{
    public function __construct()
    {
        $factory = new class implements ResponseFactoryInterface
        {
            public function createResponse($code = 200)
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
