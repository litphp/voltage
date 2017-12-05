<?php namespace Lit\Core;

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
    public function __construct(RouterInterface $router)
    {
        parent::__construct(new DispatcherHandler($router));

        $this->router = $router;
    }
}
