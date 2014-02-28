<?php
/**
 * LitPHP
 *
 * @link http://litphp.github.io/
 */

/**
 * Class Lit_Http_Conversation
 * HTTP会话封装
 * 所有HTTP相关读写都应落到这里
 */
class Lit_Http_Conversation extends Lit_Object
{
    /**
     * @return string
     *
     * 获取请求URI
     */
    public function uri()
    {
        return $this->server('REQUEST_URI');
    }

    /**
     * @param string $key
     * @return string|bool false表示不存在
     *
     * 读$_SERVER信息
     */

    public function server($key)
    {
        return isset($_SERVER[$key]) ? $_SERVER[$key] : false;
    }

    /**
     * @param string $key
     * @return string|bool false表示不存在
     *
     * 读get信息
     */
    public function get($key)
    {
        return isset($_GET[$key]) ? $_GET[$key] : false;
    }

    /**
     * @param string $key
     * @return string|bool false表示不存在
     *
     * 读post信息
     */
    public function post($key)
    {
        return isset($_POST[$key]) ? $_POST[$key] : false;
    }

    /**
     * @param string $key
     * @return string|bool false表示不存在
     *
     * 读cookie
     */
    public function cookie($key)
    {
        return isset($_COOKIE[$key]) ? $_COOKIE[$key] : false;
    }

    /**
     * @param $name
     * @param null $value
     * @param null $expire
     * @param null $path
     * @param null $domain
     * @param null $secure
     * @param null $httponly
     *
     * 写cookie
     */
    public function sendCookie(
        $name,
        $value = null,
        $expire = null,
        $path = null,
        $domain = null,
        $secure = null,
        $httponly = null
    ) {
        setcookie($name, $value, $expire, $path, $domain, $secure);
    }

    /**
     * @param $header
     * @param bool $replace
     *
     * 发送header
     */
    public function sendHeader($header, $replace = false)
    {
        header($header, $replace);
    }

    /**
     * @param int $code
     *
     * 发送HTTP Status Code
     */
    public function sendResponseCode($code)
    {
        header(' ', false, $code);
    }
}