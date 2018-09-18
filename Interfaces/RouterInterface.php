<?php

declare(strict_types=1);

namespace Lit\Core\Interfaces;

use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;

interface RouterInterface
{

    /**
     * @param ServerRequestInterface $request
     * @return RequestHandlerInterface
     */
    public function route(ServerRequestInterface $request): RequestHandlerInterface;
}
