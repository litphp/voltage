<?php

declare(strict_types=1);

namespace Lit\Voltage;

use Lit\Nimo\Handlers\AbstractHandler;
use Lit\Voltage\Interfaces\ViewInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;

abstract class AbstractAction extends AbstractHandler
{
    /**
     * @var ResponseFactoryInterface
     */
    protected $responseFactory;

    /**
     * @param ResponseInterface $response
     * @throws ThrowableResponse
     */
    protected static function throwResponse(ResponseInterface $response): void
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
        /** @var JsonView $view */
        $view = $this->attachView(new JsonView());
        return $view;
    }
}
