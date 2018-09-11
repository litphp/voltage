<?php

declare(strict_types=1);

namespace Lit\Core;

use Lit\Core\Interfaces\RouterInterface;
use Psr\Http\Server\MiddlewareInterface;

class RouterApp extends App
{
    /**
     * @var RouterDispatchHandler
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
        parent::__construct(new RouterDispatchHandler($router), $middleware);

        $this->router = $router;
    }
}
