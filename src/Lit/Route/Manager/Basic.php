<?php
/**
 * LitPHP
 *
 * @link http://litphp.github.io/
 */

/**
 * Class Lit_Route_Manager_Basic
 * 『路由器』
 * 管理多个子路由。 附带各种工厂
 */
class Lit_Route_Manager_Basic extends Lit_Route_Base
{

    /**
     * @var Lit_Route_Base[]
     */
    protected $routes = array();

    /**
     * 添加regex路由
     *
     * @param string $pattern
     * @param callable $callback,...
     * @return $this
     * @see Lit_Route_Regex
     */
    public function regex($pattern, $callback)
    {
        $callbacks = func_get_args();
        array_shift($callbacks);

        return $this->attachRoute(new Lit_Route_Regex($this->app, $pattern, $callbacks));
    }

    /**
     * 添加无条件路由
     *
     * @param callable $callback,...
     * @return $this
     * @see Lit_Route_Any
     */
    public function any($callback)
    {
        $callbacks = func_get_args();

        return $this->attachRoute(new Lit_Route_Any($this->app, $callbacks));
    }

    /**
     * 建立子路由器
     *
     * @return Lit_Route_Manager_Child
     */
    public function beginChild()
    {
        return new Lit_Route_Manager_Child($this->app, $this);
    }

    /**
     * 插入路由信息
     *
     * @param Lit_Route_Base $route
     * @return $this
     */
    public function attachRoute(Lit_Route_Base $route)
    {
        $this->routes[] = $route;

        return $this;
    }

    public function trigger()
    {
        foreach($this->routes as $route) {
            if($route->trigger($this->app)) {
                break;
            }
        }
    }
}
