<?php
/**
 * LitPHP
 *
 * @link http://litphp.github.io/
 */

/**
 * Class Lit_Object
 */
class Lit_Object
{
    function __construct(Lit_App $app)
    {
        $this->app = $app;
    }

    /**
     * @var Lit_App
     */
    protected $app;
}
