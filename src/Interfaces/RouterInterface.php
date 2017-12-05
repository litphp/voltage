<?php namespace Lit\Core\Interfaces;

use Interop\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;

interface RouterInterface
{

    /**
     * @param ServerRequestInterface $request
     * @return RequestHandlerInterface
     */
    public function route(ServerRequestInterface $request): RequestHandlerInterface;
}