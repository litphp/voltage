<?php namespace Lit\Core;

use Lit\Core\Interfaces\IView;
use Lit\Nexus\Interfaces\IPropertyInjection;
use Psr\Http\Message\ResponseInterface;

abstract class Action extends AbstractMiddleware implements IPropertyInjection
{
    /**
     * @var ResponseInterface
     */
    protected $responsePrototype;
    public static function getInjectedProperties()
    {
        return [
            'responsePrototype' => ResponseInterface::class,
        ];
    }

    /**
     * @param IView $view
     * @return IView
     */
    protected function attachView(IView $view)
    {
        return $view->setResponse($this->responsePrototype);
    }
}
