<?php

declare(strict_types=1);

namespace Lit\Voltage\Interfaces;

use Psr\Http\Message\ResponseInterface;

interface ThrowableResponseInterface
{
    public function getResponse(): ResponseInterface;
}
