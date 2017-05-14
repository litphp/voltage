<?php namespace Lit\Core;

use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Lit\Core\Interfaces\IRouter;
use Psr\Http\Message\ResponseInterface;
use Zend\Stratigility\MiddlewarePipe;
use Zend\Stratigility\Route;

/**
 * the lit app class
 */
class App extends MiddlewarePipe
{
    /**
     * App constructor.
     * @param IRouter $router
     */
    public function __construct(IRouter $router, ResponseInterface $responsePrototype)
    {
        parent::__construct();

        $this->setResponsePrototype($responsePrototype);
        $this->pipe(new DispatcherMiddleware($router));
    }

    public function prepend(MiddlewareInterface $middleware, $path = '/')
    {
        $this->pipeline->unshift(new Route($path, $middleware));
        return $this;
    }
}
