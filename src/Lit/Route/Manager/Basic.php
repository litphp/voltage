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
     * @param $pattern string
     * @param $callback callback
     * @return $this
     *
     * 添加regex路由 {@see Lit_Route_Regex}
     */
    public function regex($pattern, $callback)
    {
        return $this->attachRoute(new Lit_Route_Regex($this->app, $pattern, $callback));
    }

    /**
     * @param $callback callback
     * @return $this
     *
     * 添加无条件路由 {@see Lit_Route_Any}
     */
    public function any($callback)
    {
        return $this->attachRoute(new Lit_Route_Any($this->app, $callback));
    }

    /**
     * @return Lit_Route_Manager_Child
     *
     * 建立子路由器
     */
    public function beginChild()
    {
        return new Lit_Route_Manager_Child($this->app, $this);
    }

    /**
     * @param Lit_Route_Base $route
     * @return $this
     *
     * 插入路由信息
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
