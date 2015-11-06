<?php namespace Lit\Core;

use Lit\Core\Interfaces\IAppAware;
use Lit\Core\Interfaces\IView;
use Lit\Core\Traits\AppAwareTrait;
use Nimo\AbstractMiddleware;

abstract class Action extends AbstractMiddleware implements IAppAware
{
    use AppAwareTrait;

    protected function renderView(IView $view, array $data = [])
    {
        return $view->render($data, $this->response);
    }
}
