<?php

declare(strict_types=1);

namespace Lit\Voltage\Interfaces;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Standard interface for http router
 */
interface RouterInterface
{
    /**
     * Find the corresponding RequestHandler according to the request
     *
     * @param ServerRequestInterface $request The incoming request.
     * @return RequestHandlerInterface
     */
    public function route(ServerRequestInterface $request): RequestHandlerInterface;
}
