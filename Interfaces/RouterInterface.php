<?php

declare(strict_types=1);

namespace Lit\Voltage\Interfaces;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

interface RouterInterface
{

    /**
     * Find the corresponding RequestHandler according to the input $request
     *
     * @param ServerRequestInterface $request
     * @return RequestHandlerInterface
     */
    public function route(ServerRequestInterface $request): RequestHandlerInterface;
}
