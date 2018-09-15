<?php

declare(strict_types=1);

namespace Lit\Core;

use Lit\Core\Interfaces\RouterStubResolverInterface;
use Psr\Http\Server\RequestHandlerInterface;

class RouteStubResolver implements RouterStubResolverInterface
{
    public function resolve($stub): RequestHandlerInterface
    {
        return $stub;
    }
}
