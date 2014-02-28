<?php
/**
 * LitPHP
 *
 * @link http://litphp.github.io/
 */

/**
 * Class Lit_Object
 *
 * 包装app引用，推荐用这种方式传递app引用而非 Lit_App::current
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
