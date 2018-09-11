<?php

use Lit\Core\Action;
use Lit\Core\App;
use Lit\Core\BasicRouter;
use Lit\Core\Interfaces\RouterStubResolverInterface;
use Lit\Core\RouterDispatchHandler;
use Lit\Nimo\Handlers\FixedResponseHandler;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequestFactory;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;

// @codeCoverageIgnoreStart

/** @noinspection PhpIncludeInspection */
require(__DIR__ . '/../vendor/autoload.php');

class NotFoundAction extends Action
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
            'not' => 'found',
            'method' => $this->request->getMethod(),
            'uri' => $this->request->getUri()->__toString(),
        ])->withStatus(404);
    }
}

$stubResolver = new class implements RouterStubResolverInterface
{
    public function resolve($stub): RequestHandlerInterface
    {
        return $stub;
    }
};
$router = new BasicRouter($stubResolver, new NotFoundAction);

$testJson = new Response\JsonResponse([
    'test.json' => 'should be this',
    'bool' => false,
    'nil' => null,
]);
$router->get('/test.json', FixedResponseHandler::wrap($testJson));
$app = new App(new RouterDispatchHandler($router));

$request = ServerRequestFactory::fromGlobals();
$response = $app->handle($request);
$emitter = new SapiEmitter();
$emitter->emit($response);

// @codeCoverageIgnoreEnd
