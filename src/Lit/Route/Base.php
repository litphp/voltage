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
     * @return bool
     *
     * 触发，返回true表示break
     */
    abstract public function trigger();
}
