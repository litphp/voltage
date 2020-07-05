<?php

/**
 * @codeCoverageIgnoreStart
 * phpcs:disable PSR1.Files.SideEffects
 * phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace
 */

use Laminas\Diactoros\ResponseFactory;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Lit\Voltage\AbstractAction;
use Lit\Voltage\App;
use Psr\Http\Message\ResponseInterface;

/** @noinspection PhpIncludeInspection */
require_once __DIR__ . '/../vendor/autoload.php';

class HelloAction extends AbstractAction
{
    public function __construct()
    {
        $this->responseFactory = new ResponseFactory();
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
