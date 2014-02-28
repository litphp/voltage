<?php
/**
 * LitPHP
 *
 * @link http://litphp.github.io/
 */

/**
 * Class Lit_Route_Regex
 * 正则匹配URI
 *
 * 匹配命中时，会中断路由过程
 * 同时会写context
 */
class Lit_Route_Regex extends Lit_Route_Base
{
    const MATCHES = 'Route.Regex.matches';
    protected $pattern;
    protected $callback;

    /**
     * @param Lit_App $app
     * @param string $pattern 匹配的正则
     * @param callback $callback 要触发的cb
     */
    function __construct($app, $pattern, $callback)
    {
        $this->pattern = $pattern;
        $this->callback = $callback;

        parent::__construct($app);
    }

    public function trigger()
    {
        $matches = array();
        $uri = $this->app->http()->uri();
        $uri = preg_replace('/\\?.*$/', '', $uri);
        $match = preg_match($this->pattern, $uri, $matches);
        if($match) {
            $this->app->writeContext(self::MATCHES, $matches);
            return call_user_func($this->callback, $this->app);
        }

        return false;
    }
}
