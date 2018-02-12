<?php namespace Lit\Core;

use Psr\Http\Server\MiddlewareInterface;
use Lit\Core\Interfaces\RouterInterface;

class RouterApp extends App
{
    /**
     * @var DispatcherHandler
     */
    protected $dispatcherHandler;
    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * App constructor.
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router, MiddlewareInterface $middleware = null)
    {
        parent::__construct(new DispatcherHandler($router), $middleware);

        $this->router = $router;
    }
}
