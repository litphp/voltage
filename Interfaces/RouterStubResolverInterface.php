<?php

declare(strict_types=1);

namespace Lit\Core\Interfaces;

use Psr\Http\Server\RequestHandlerInterface;

interface RouterStubResolverInterface
{
    /**
     * resolve the stub
     * @param $stub
     * @return RequestHandlerInterface
     */
    public function resolve($stub): RequestHandlerInterface;
}
