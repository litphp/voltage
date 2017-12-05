<?php namespace Lit\Core\Interfaces;

use Interop\Http\Server\RequestHandlerInterface;

interface RouterStubResolverInterface
{
    /**
     * resolve the stub
     * @param $stub
     * @return RequestHandlerInterface
     */
    public function resolve($stub): RequestHandlerInterface;
}
