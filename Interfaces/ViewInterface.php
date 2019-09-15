<?php

declare(strict_types=1);

namespace Lit\Voltage\Interfaces;

use Psr\Http\Message\ResponseInterface;

/**
 * Interface for view class
 */
interface ViewInterface
{
    /**
     * Render the response using $data
     *
     * @param array $data Data to be rendered.
     * @return ResponseInterface
     */
    public function render(array $data = []): ResponseInterface;

    /**
     * Accept the response prototype
     *
     * @param ResponseInterface $response The PSR response prototype.
     * @return void
     */
    public function setResponse(ResponseInterface $response): void;
}
