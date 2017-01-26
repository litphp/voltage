<?php namespace Lit\Core;

use Lit\Core\Interfaces\IRouter;
use Nimo\MiddlewareStack;

/**
 * the lit app class
 */
class App extends MiddlewareStack
{
    /**
     * App constructor.
     * @param IRouter $router
     */
    public function __construct(IRouter $router)
    {
        $this->append(new DispatcherMiddleware($router));
    }
}
