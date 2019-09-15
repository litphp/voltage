<?php

declare(strict_types=1);

namespace Lit\Voltage;

use Lit\Nimo\Handlers\AbstractHandler;
use Lit\Nimo\Middlewares\MiddlewarePipe;
use Lit\Voltage\Interfaces\ThrowableResponseInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * App is a complete PSR-15 application, including a middleware pipe and a concrete business handler.
 */
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

    /**
     * App constructor
     *
     * @param RequestHandlerInterface  $businessLogicHandler The concrete request handler.
     * @param MiddlewareInterface|null $middleware           Optional. A middleware pipe will be created if this is not
     *                                                       instance of MiddlewarePipe.
     */
    public function __construct(RequestHandlerInterface $businessLogicHandler, MiddlewareInterface $middleware = null)
    {
        $this->businessLogicHandler = $businessLogicHandler;
        $this->middlewarePipe = $middleware
            ? ($middleware instanceof MiddlewarePipe ? $middleware : (new MiddlewarePipe())->append($middleware))
            : new MiddlewarePipe();
    }

    /**
     * Getter for middleware pipe
     *
     * @return MiddlewarePipe
     */
    public function getMiddlewarePipe(): MiddlewarePipe
    {
        return $this->middlewarePipe;
    }

    /**
     * @return ResponseInterface
     */
    protected function main(): ResponseInterface
    {
        try {
            return $this->middlewarePipe->process($this->request, $this->businessLogicHandler);
        } catch (ThrowableResponseInterface $e) {
            return $e->getResponse();
        }
    }
}
