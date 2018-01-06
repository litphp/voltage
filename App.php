<?php namespace Lit\Core;

use Interop\Http\Server\MiddlewareInterface;
use Interop\Http\Server\RequestHandlerInterface;
use Lit\Core\Interfaces\ThrowableResponseInterface;
use Nimo\AbstractHandler;
use Nimo\MiddlewarePipe;
use Psr\Http\Message\ResponseInterface;

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
