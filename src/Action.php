<?php namespace Lit\Core;

use Lit\Core\Interfaces\IView;
use Nimo\AbstractMiddleware;

abstract class Action extends AbstractMiddleware
{
    /**
     * @param IView $view
     * @return IView
     */
    protected function attachView(IView $view)
    {
        return $view->setResponse($this->response);
    }
}
