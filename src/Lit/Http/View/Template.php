<?php
/**
 * LitPHP
 *
 * @link http://litphp.github.io/
 */

/**
 * Class Lit_Http_View_Template
 * 用模板输出页面
 */
abstract class Lit_Http_View_Template extends Lit_Http_View
{
    protected $template;

    /**
     * @param Lit_App $app
     * @param mixed $template 模板名
     */
    function __construct(Lit_App $app, $template)
    {
        parent::__construct($app);
        $this->template = $template;
    }

    public function output()
    {
        $this->body = $this->render($this->template);
        parent::output();
    }

    /**
     * @param $template
     * @return string
     */
    protected function render($template)
    {
        return $this->template()->render($template, $this->data());
    }

    /**
     * @return Lit_ITemplate
     *
     * 拿模板引擎
     */
    abstract protected function template();

    /**
     * @return mixed
     *
     * 生成渲染数据
     */
    abstract protected function data();
}
