<?php
/**
 * LitPHP
 *
 * @link http://litphp.github.io/
 */

/**
 * Class Lit_App
 * app对象，全局大工厂
 */
class Lit_App
{
    /**
     * @var Lit_Result
     */
    protected $result;
    /**
     * @var Lit_Route_Manager_Basic
     */
    protected $router;
    /**
     * @var array
     */
    protected $context;
    /**
     * @var Lit_Http_Conversation
     */
    protected $http;


    /**
     * 运行app
     */
    public function run()
    {
        $this->router()->trigger();
        $this->result()->output();
    }

    /**
     * @return Lit_Route_Manager_Basic
     *
     * 路由器工厂
     */
    public function router()
    {
        if (!isset($this->router)) {
            $this->router = new Lit_Route_Manager_Basic($this);
        }

        return $this->router;
    }

    /**
     * @return Lit_Result
     * @throws Exception 未定义结果时抛错
     *
     * 取本次运行的结果
     */
    public function result()
    {
        if (!isset($this->result)) {
            throw new Exception('result not set');
        }

        return $this->result;
    }

    /**
     * @param Lit_Result $result
     * @return $this
     * @throws Exception 重复定义时抛错
     *
     * 设置本次运行的结果，一般由“控制器”调用
     */
    public function setResult(Lit_Result $result)
    {
        if (isset($this->result)) {
            throw new Exception('redefine app result');
        }
        $this->result = $result;

        return $this;
    }

    /**
     * @param string $key
     * @return mixed
     * @throws Exception
     *
     * 读取context
     */
    public function context($key)
    {
        if (!isset($this->context[$key])) {
            throw new Exception('undefined context key:' . $key
            );
        }

        return $this->context[$key];
    }

    /**
     * @param string $key
     * @param mixed $val
     * @return $this
     * @throws Exception
     *
     * 写入context
     */
    public function writeContext($key, $val)
    {
        if (isset($this->context[$key])) {
            throw new Exception('redefine context key:' . $key);
        }

        $this->context[$key] = $val;

        return $this;
    }

    /**
     * @return Lit_Http_Conversation
     *
     * HTTP会话管理器工厂
     */
    public function http()
    {
        if(!isset($this->http))
        {
            $this->http = new Lit_Http_Conversation($this);
        }

        return $this->http;
    }
}
