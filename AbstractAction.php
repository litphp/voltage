<?php

declare(strict_types=1);

namespace Lit\Voltage;

use Lit\Nimo\Handlers\AbstractHandler;
use Lit\Voltage\Interfaces\ViewInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Base class for actions.
 *
 * It's strongly recommended to have your own action base class extending this one
 */
abstract class AbstractAction extends AbstractHandler
{
    /**
     * @var ResponseFactoryInterface
     */
    protected $responseFactory;

    /**
     * Halt execution and return the given response.
     *
     * @param ResponseInterface $response The response to be thrown.
     * @throws ThrowableResponse Throws a standard exception containing given response.
     * @return void
     */
    protected static function throwResponse(ResponseInterface $response): void
    {
        throw ThrowableResponse::of($response);
    }

    /**
     * @param ViewInterface $view The view instance to be used with this action.
     * @return ViewInterface
     */
    protected function attachView(ViewInterface $view)
    {
        $view->setResponse($this->responseFactory->createResponse());

        return $view;
    }

    /**
     * @return JsonView
     */
    protected function json(): JsonView
    {
        /** @var JsonView $view */
        $view = $this->attachView(new JsonView());
        return $view;
    }
}
