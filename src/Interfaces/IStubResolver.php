<?php namespace Lit\Core\Interfaces;

use Interop\Http\ServerMiddleware\MiddlewareInterface;

interface IStubResolver
{
    /**
     * resolve the stub
     * @param $stub
     * @return MiddlewareInterface $middleware
     */
    public function resolve($stub);
}
