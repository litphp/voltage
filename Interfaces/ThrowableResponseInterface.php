<?php

declare(strict_types=1);

namespace Lit\Core\Interfaces;

use Psr\Http\Message\ResponseInterface;

interface ThrowableResponseInterface
{
    public function getResponse(): ResponseInterface;
}
