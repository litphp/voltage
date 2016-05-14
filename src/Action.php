<?php namespace Lit\Core;

use Lit\Core\Interfaces\IView;
use Nimo\AbstractMiddleware;

abstract class Action extends AbstractMiddleware
{
    protected function renderView(IView $view, array $data = [])
    {
        return $view->render($data, $this->response);
    }
}
