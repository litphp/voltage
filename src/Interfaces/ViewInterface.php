<?php namespace Lit\Core\Interfaces;

use Psr\Http\Message\ResponseInterface;

interface ViewInterface
{
    /**
     * @param array $data
     * @return ResponseInterface
     */
    public function render(array $data = []): ResponseInterface;

    /**
     * @param ResponseInterface $response
     */
    public function setResponse(ResponseInterface $response): void;
}
