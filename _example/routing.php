<?php

use Http\Factory\Diactoros\ResponseFactory;
use Lit\Core\AbstractAction;
use Lit\Core\App;
use Lit\Core\BasicRouter;
use Lit\Core\RouteStubResolver;
use Lit\Nimo\Handlers\FixedResponseHandler;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequestFactory;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;

// @codeCoverageIgnoreStart

/** @noinspection PhpIncludeInspection */
require(__DIR__ . '/../vendor/autoload.php');

class NotFoundAbstractAction extends AbstractAction
{
    public function __construct()
    {
        $this->responseFactory = new ResponseFactory();
    }

    protected function main(): ResponseInterface
    {
        return $this->json()->render([
            'not' => 'found',
            'method' => $this->request->getMethod(),
            'uri' => $this->request->getUri()->__toString(),
        ])->withStatus(404);
    }
}

$stubResolver = new RouteStubResolver();
$router = new BasicRouter($stubResolver, new NotFoundAbstractAction);

$testJson = new Response\JsonResponse([
    'test.json' => 'should be this',
    'bool' => false,
    'nil' => null,
]);
$router->get('/test.json', FixedResponseHandler::wrap($testJson));
$app = new App($router->makeDispatcher());

$request = ServerRequestFactory::fromGlobals();
$response = $app->handle($request);
$emitter = new SapiEmitter();
$emitter->emit($response);

// @codeCoverageIgnoreEnd
