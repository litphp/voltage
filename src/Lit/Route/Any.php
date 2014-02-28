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
    /**
     * @param Lit_App $app
     * @param callback $callback 出发的cb
     *
     */
    function __construct($app, $callback)
    {
        $this->callback = $callback;

        parent::__construct($app);
    }

    public function trigger()
    {
        return call_user_func($this->callback, $this->app);
    }

    protected $callback;
}
