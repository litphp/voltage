<?php namespace Lit\Core;

use Lit\Core\Interfaces\IRouter;
use Nimo\AbstractMiddleware;

class DispatcherMiddleware extends AbstractMiddleware
{
    /**
     * @var IRouter
     */
    protected $router;

    public function __construct(IRouter $router)
    {
        $this->router = $router;
    }

    protected function main()
    {
        $action = $this->router->route($this->request);

        return $this->invokeCallback($action);
    }
}
