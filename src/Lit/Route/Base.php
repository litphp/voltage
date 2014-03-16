<?php
/**
 * LitPHP
 *
 * @link http://litphp.github.io/
 */

/**
 * Class Lit_Route_Base
 * 路由基类
 */
abstract class Lit_Route_Base extends Lit_Object
{
    /**
     * 触发，返回true表示break
     *
     * @return bool
     */
    abstract public function trigger();

    /**
     * @param $callbacks
     * @return bool
     */
    protected function invokeCallbacks($callbacks)
    {
        $flag = false;
        foreach ($callbacks as $callback) {
            $flag = call_user_func($callback, $this->app);
            if ($flag) break;
        }

        return !!$flag;
    }
}
