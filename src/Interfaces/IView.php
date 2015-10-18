<?php namespace Lit\Core\Interfaces;

use Psr\Http\Message\ResponseInterface;

interface IView
{
    /**
     * @param array $data
     * @param ResponseInterface $resp
     * @return ResponseInterface
     */
    public function render(array $data, ResponseInterface $resp);
}