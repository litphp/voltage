<?php

declare(strict_types=1);

namespace Lit\Voltage\Interfaces;

use Psr\Http\Server\RequestHandlerInterface;

/**
 * Interface for a stub resolver used with router
 */
interface RouterStubResolverInterface
{
    /**
     * Resolve the stub and return a RequestHandler
     *
     * @param mixed $stub The stub value to be resolved.
     * @return RequestHandlerInterface
     */
    public function resolve($stub): RequestHandlerInterface;
}
