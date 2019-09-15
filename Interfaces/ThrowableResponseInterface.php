<?php

declare(strict_types=1);

namespace Lit\Voltage\Interfaces;

use Psr\Http\Message\ResponseInterface;

/**
 * Interface for a throwable response (exception that contains a response)
 */
interface ThrowableResponseInterface
{
    /**
     * Getter for the inside response
     * @return ResponseInterface
     */
    public function getResponse(): ResponseInterface;
}
