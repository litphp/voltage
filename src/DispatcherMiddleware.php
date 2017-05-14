<?php namespace Lit\Core;

use Lit\Core\Interfaces\IRouter;

class DispatcherMiddleware extends AbstractMiddleware
{
    /**
     * @var IRouter
     */
    protected $router;

    /**
     * DispatcherMiddleware constructor.
     * @param IRouter $router
     */
    public function __construct(IRouter $router)
    {
        $this->router = $router;
    }

    protected function main()
    {
        $action = $this->router->route($this->request);

        return $action->process($this->request, $this->delegate);
    }
}
