<?php
/**
 * LitPHP
 *
 * @link http://litphp.github.io/
 */

/**
 * Interface Lit_ITemplate
 * 模板引擎接口
 */
interface Lit_ITemplate
{
    /**
     * @param $template mixed 指定使用哪个模板
     * @param $data mixed 模板渲染用数据
     * @return string 渲染结果
     */
    public function render($template, $data);
}
