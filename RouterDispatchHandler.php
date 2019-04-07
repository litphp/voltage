<?php

declare(strict_types=1);

namespace Lit\Voltage;

use Lit\Voltage\Interfaces\RouterInterface;
use Lit\Nimo\AbstractHandler;
use Psr\Http\Message\ResponseInterface;

class RouterDispatchHandler extends AbstractHandler
{
    /**
     * @var RouterInterface
     */
    protected $router;

    /**
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
