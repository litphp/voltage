<?php namespace Lit\Core;

use Interop\Http\Factory\ResponseFactoryInterface;
use Lit\Core\Interfaces\ViewInterface;
use Nimo\AbstractHandler;

abstract class Action extends AbstractHandler
{
    /**
     * @var ResponseFactoryInterface
     */
    protected $responseFactory;

    /**
     * @param ViewInterface $view
     * @return ViewInterface
     */
    protected function attachView(ViewInterface $view)
    {
        return $view->setResponse($this->responseFactory->createResponse());
    }

    protected function json(): JsonView
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->attachView(new JsonView());
    }
}
