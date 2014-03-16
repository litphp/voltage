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
     * 获取请求URI
     *
     * @return string
     */
    public function uri()
    {
        return $this->server('REQUEST_URI');
    }

    /**
     * 读$_SERVER信息
     *
     * @param string $key
     * @return string|bool false表示不存在
     */

    public function server($key)
    {
        return isset($_SERVER[$key]) ? $_SERVER[$key] : false;
    }

    /**
     * 读get信息
     *
     * @param string $key
     * @return string|bool false表示不存在
     */
    public function get($key)
    {
        return isset($_GET[$key]) ? $_GET[$key] : false;
    }

    /**
     * 读post信息
     *
     * @param string $key
     * @return string|bool false表示不存在
     */
    public function post($key)
    {
        return isset($_POST[$key]) ? $_POST[$key] : false;
    }

    /**
     * 读上传文件信息
     *
     * @param $key
     * @return array|bool false表示不存在
     */
    public function file($key)
    {
        return isset($_FILES[$key]) ? $_FILES[$key] : false;
    }

    /**
     * 读cookie
     *
     * @param string $key
     * @return string|bool false表示不存在
     */
    public function cookie($key)
    {
        return isset($_COOKIE[$key]) ? $_COOKIE[$key] : false;
    }

    /**
     * 写cookie
     *
     * @param $name
     * @param null $value
     * @param null $expire
     * @param null $path
     * @param null $domain
     * @param null $secure
     * @param null $httponly
     * @return $this
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

        return $this;
    }

    /**
     * 发送header
     *
     * @param $header
     * @param bool $replace
     * @return $this
     */
    public function sendHeader($header, $replace = false)
    {
        header($header, $replace);

        return $this;
    }

    /**
     * 发送HTTP Status Code
     *
     * @param int $code
     * @return $this
     */
    public function sendResponseCode($code)
    {
        header(' ', false, $code);
        return $this;
    }
}