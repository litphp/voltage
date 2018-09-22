<?php

declare(strict_types=1);

namespace Lit\Core;

use Lit\Core\Interfaces\ViewInterface;
use Lit\Core\Traits\ViewTrait;

abstract class AbstractView implements ViewInterface
{
    use ViewTrait;
}
