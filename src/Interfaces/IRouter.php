<?php namespace Lit\Core\Interfaces;

use Nimo\AbstractMiddleware;
use Psr\Http\Message\ServerRequestInterface;

interface IRouter
{

    /**
     * @param ServerRequestInterface $req
     * @return AbstractMiddleware
     */
    public function route(ServerRequestInterface $req);
}