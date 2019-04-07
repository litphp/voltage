<?php

declare(strict_types=1);

namespace Lit\Voltage\Interfaces;

use Psr\Http\Message\ResponseInterface;

interface ViewInterface
{
    /**
     * Render the response using $data
     *
     * @param array $data
     * @return ResponseInterface
     */
    public function render(array $data = []): ResponseInterface;

    /**
     * Accept the response prototype
     *
     * @param ResponseInterface $response
     */
    public function setResponse(ResponseInterface $response): void;
}
