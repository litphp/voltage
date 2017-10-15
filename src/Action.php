<?php namespace Lit\Core;

use Lit\Core\Interfaces\IView;
use Psr\Http\Message\ResponseInterface;

abstract class Action extends AbstractMiddleware
{
    /**
     * @var ResponseInterface
     */
    protected $responsePrototype;

    /**
     * @param IView $view
     * @return IView
     */
    protected function attachView(IView $view)
    {
        return $view->setResponse($this->responsePrototype);
    }
}
