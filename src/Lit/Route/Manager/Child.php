<?php
/**
 * LitPHP
 *
 * @link http://litphp.github.io/
 */

/**
 * Class Lit_Route_Manager_Child
 *
 * 子路由器
 * 注意因为继承，所以嵌套下去
 */
class Lit_Route_Manager_Child extends Lit_Route_Manager_Basic
{
    protected $parent;

    function __construct(Lit_App $app, Lit_Route_Manager_Basic $parent)
    {
        parent::__construct($app);
        $this->parent = $parent;
    }

    /**
     * @return Lit_Route_Manager_Basic
     *
     * 将自己作为节点插入父路由器
     * 返回父路由器，完成帅气的chain method api
     */
    public function endChild()
    {
        $this->parent->attachRoute($this);
        return $this->parent;
    }
}
