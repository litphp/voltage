<?php namespace Lit\Core\Interfaces;

use Psr\Http\Message\ResponseInterface;

interface ViewInterface
{
    /**
     * @param array $data
     * @return ResponseInterface
     */
    public function render(array $data = []);

    /**
     * @param ResponseInterface $response
     * @return $this
     */
    public function setResponse(ResponseInterface $response);
}
