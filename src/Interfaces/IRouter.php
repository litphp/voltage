<?php namespace Lit\Core\Interfaces;

use Nimo\AbstractMiddleware;
use Psr\Http\Message\ServerRequestInterface;

interface IRouter
{

    /**
     * @param ServerRequestInterface $request
     * @return AbstractMiddleware|callable
     */
    public function route(ServerRequestInterface $request);
}