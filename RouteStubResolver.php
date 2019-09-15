<?php

declare(strict_types=1);

namespace Lit\Voltage;

use Lit\Voltage\Interfaces\RouterStubResolverInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Basic router stub resolver that do nothing but just use stub itself as request handler.
 */
class RouteStubResolver implements RouterStubResolverInterface
{
    /**
     * @param mixed $stub The stub value to be resolved.
     * @return RequestHandlerInterface
     */
    public function resolve($stub): RequestHandlerInterface
    {
        return $stub;
    }
}
