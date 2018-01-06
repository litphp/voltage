<?php

use Interop\Http\Factory\ResponseFactoryInterface;
use Interop\Http\Server\RequestHandlerInterface;
use Lit\Core\Action;
use Lit\Core\BasicRouter;
use Lit\Core\Interfaces\RouterStubResolverInterface;
use Lit\Core\RouterApp;
use Nimo\Handlers\FixedResponseHandler;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response;
use Zend\Diactoros\Response\SapiEmitter;
use Zend\Diactoros\ServerRequestFactory;


require(__DIR__ . '/../vendor/autoload.php');

class NotFoundAction extends Action
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
$app = new RouterApp($router);

$request = ServerRequestFactory::fromGlobals();
$response = $app->handle($request);
$emitter = new SapiEmitter();
$emitter->emit($response);
