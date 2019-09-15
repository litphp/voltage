<?php

declare(strict_types=1);

namespace Lit\Voltage;

use Lit\Nimo\Handlers\AbstractHandler;
use Lit\Voltage\Interfaces\RouterInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Handle request with embeded router
 */
class RouterDispatchHandler extends AbstractHandler
{
    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * @param RouterInterface $router Router instance to be used.
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * @return ResponseInterface
     */
    protected function main(): ResponseInterface
    {
        $action = $this->router->route($this->request);

        return $action->handle($this->request);
    }
}
