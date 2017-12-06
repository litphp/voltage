<?php namespace Lit\Core;

use Interop\Http\Server\RequestHandlerInterface;
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

    public function __construct(RequestHandlerInterface $businessLogicHandler)
    {
        $this->businessLogicHandler = $businessLogicHandler;
        $this->middlewarePipe = new MiddlewarePipe();
    }

    protected function main(): ResponseInterface
    {
        return $this->middlewarePipe->process($this->request, $this->businessLogicHandler);
    }
}
