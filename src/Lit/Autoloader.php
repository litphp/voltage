<?php
/**
 * LitPHP
 *
 * @link http://litphp.github.io/
 */

/**
 * Class Lit_Autoloader
 * 负责自动加载class文件
 */
class Lit_Autoloader
{
    private $root;

    /**
     * @param $root string 路径
     * @return Lit_Autoloader
     *
     * 注册$root为自动加载搜索路径
     */
    public static function register($root)
    {
        return new self($root);
    }

    protected function __construct($root)
    {
        $this->root = $root;

        spl_autoload_register(array($this, 'autoload'));
    }

    /**
     * @param $class
     * @return bool
     *
     * 自动加载callback
     * 如果加载的类有 public static _onLoad，则调用
     */
    public function autoload($class)
    {
        $filepath = $this->root . DIRECTORY_SEPARATOR . str_replace('_', DIRECTORY_SEPARATOR, $class . '.php');
        if (is_readable($filepath)) {
            /** @noinspection PhpIncludeInspection */
            require($filepath);

            $callback = array($class, '_onLoad');
            if (is_callable($callback)) call_user_func($callback);
        }

        return false;
    }
}
