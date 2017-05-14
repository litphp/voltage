<?php namespace Lit\Core;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;

abstract class AbstractMiddleware implements MiddlewareInterface
{
    /**
     * @var ServerRequestInterface
     */
    protected $request;

    /**
     * @var DelegateInterface
     */
    protected $delegate;

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $this->request = $request;
        $this->delegate = $delegate;

        return $this->main();
    }

    abstract protected function main();

    protected function next(ServerRequestInterface $request = null)
    {
        return $this->delegate->process($request ?: $this->request);
    }
}
