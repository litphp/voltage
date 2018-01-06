<?php namespace Lit\Core;

use Lit\Core\Interfaces\RouterInterface;
use Nimo\AbstractHandler;
use Psr\Http\Message\ResponseInterface;

class DispatcherHandler extends AbstractHandler
{
    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * DispatcherMiddleware constructor.
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    protected function main(): ResponseInterface
    {
        $action = $this->router->route($this->request);

        return $action->handle($this->request);
    }
}
