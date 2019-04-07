<?php

declare(strict_types=1);

namespace Lit\Voltage;

use Lit\Voltage\Interfaces\ThrowableResponseInterface;
use Lit\Nimo\AbstractHandler;
use Lit\Nimo\MiddlewarePipe;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class App extends AbstractHandler
{
    /**
     * @var MiddlewarePipe
     */
    protected $middlewarePipe;
    /**
     * @var RequestHandlerInterface
     */
    protected $businessLogicHandler;

    public function __construct(RequestHandlerInterface $businessLogicHandler, MiddlewareInterface $middleware = null)
    {
        $this->businessLogicHandler = $businessLogicHandler;
        $this->middlewarePipe = $middleware
            ? ($middleware instanceof MiddlewarePipe ? $middleware : (new MiddlewarePipe())->append($middleware))
            : new MiddlewarePipe();
    }

    /**
     * @return MiddlewarePipe
     */
    public function getMiddlewarePipe(): MiddlewarePipe
    {
        return $this->middlewarePipe;
    }

    protected function main(): ResponseInterface
    {
        try {
            return $this->middlewarePipe->process($this->request, $this->businessLogicHandler);
        } catch (ThrowableResponseInterface $e) {
            return $e->getResponse();
        }
    }
}
