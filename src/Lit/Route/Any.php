<?php
/**
 * LitPHP
 *
 * @link http://litphp.github.io/
 */

/**
 * Class Lit_Route_Any
 * 无条件触发路由
 */
class Lit_Route_Any extends Lit_Route_Base
{
    protected $callbacks;

    /**
     * @param Lit_App $app
     * @param callback[] $callbacks
     */
    function __construct($app, $callbacks)
    {
        $this->callbacks = $callbacks;

        parent::__construct($app);
    }

    public function trigger()
    {
        return $this->invokeCallbacks($this->callbacks);
    }
}
