<?php
/**
 * LitPHP
 *
 * @link http://litphp.github.io/
 */

/**
 * Class Lit_Http_View
 * HTTP输出
 */
class Lit_Http_View extends Lit_Result
{
    public function output()
    {
        $this->app->http()->sendResponseCode($this->status);
        echo $this->body;
    }

    /**
     * @var string
     * response body
     */
    public $body = '';
    /**
     * @var int
     * status code
     */
    public $status = 200;
}