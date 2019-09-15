<?php

declare(strict_types=1);

namespace Lit\Voltage;

use Lit\Voltage\Interfaces\ViewInterface;
use Lit\Voltage\Traits\ViewTrait;

/**
 * Base class for standard view implementations.
 */
abstract class AbstractView implements ViewInterface
{
    use ViewTrait;
}
