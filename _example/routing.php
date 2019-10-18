<?php

/**
 * @codeCoverageIgnoreStart
 * phpcs:disable PSR1.Files.SideEffects
 * phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace
 */

use Lit\Nimo\Handlers\FixedResponseHandler;
use Lit\Voltage\AbstractAction;
use Lit\Voltage\App;
use Lit\Voltage\BasicRouter;
use Lit\Voltage\RouteStubResolver;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response;
use Zend\Diactoros\ResponseFactory;
use Zend\Diactoros\ServerRequestFactory;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;

/** @noinspection PhpIncludeInspection */
require_once __DIR__ . '/../vendor/autoload.php';

class NotFoundAction extends AbstractAction
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
$router = new BasicRouter($stubResolver, new NotFoundAction());

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
