<?php namespace Lit\Core\Interfaces;

interface IStubResolver
{
    /**
     * resolve the stub
     * @param $stub
     * @return callable $middleware
     */
    public function resolve($stub);
}
