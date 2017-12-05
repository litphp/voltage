<?php namespace Lit\Core;

use Interop\Http\Server\RequestHandlerInterface;
use Nimo\AbstractHandler;
use Nimo\MiddlewareStack;
use Psr\Http\Message\ResponseInterface;

class App extends AbstractHandler
{
    /**
     * @var MiddlewareStack
     */
    protected $middlewareStack;
    /**
     * @var RequestHandlerInterface
     */
    protected $businessLogicHandler;

    public function __construct(RequestHandlerInterface $businessLogicHandler)
    {
        $this->businessLogicHandler = $businessLogicHandler;
        $this->middlewareStack = new MiddlewareStack();
    }

    protected function main(): ResponseInterface
    {
        return $this->middlewareStack->process($this->request, $this->businessLogicHandler);
    }
}
