<?php namespace Lit\Core;

use Interop\Http\Factory\ResponseFactoryInterface;
use Lit\Core\Interfaces\ViewInterface;
use Lit\Nimo\AbstractHandler;
use Psr\Http\Message\ResponseInterface;

abstract class Action extends AbstractHandler
{
    /**
     * @var ResponseFactoryInterface
     */
    protected $responseFactory;

    /**
     * @param ResponseInterface $response
     * @throws ThrowableResponse
     */
    public static function throwResponse(ResponseInterface $response): void
    {
        throw ThrowableResponse::of($response);
    }

    /**
     * @param ViewInterface $view
     * @return ViewInterface
     */
    protected function attachView(ViewInterface $view)
    {
        $view->setResponse($this->responseFactory->createResponse());

        return $view;
    }

    protected function json(): JsonView
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->attachView(new JsonView());
    }
}
