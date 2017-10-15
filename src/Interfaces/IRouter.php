<?php namespace Lit\Core\Interfaces;

use Lit\Core\AbstractMiddleware;
use Psr\Http\Message\ServerRequestInterface;

interface IRouter
{

    /**
     * @param ServerRequestInterface $request
     * @return AbstractMiddleware
     */
    public function route(ServerRequestInterface $request);
}