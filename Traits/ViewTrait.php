<?php

declare(strict_types=1);

namespace Lit\Voltage\Traits;

use Psr\Http\Message\ResponseInterface;

/**
 * Implements ViewInterface and provide a helper method getEmptyBody.
 */
trait ViewTrait
{
    /**
     * @var ResponseInterface
     */
    protected $response;

    /**
     * @ses \Lit\Voltage\Interfaces\ViewInterface::setResponse
     * @param ResponseInterface $response Set the response prototype.
     * @return void
     */
    public function setResponse(ResponseInterface $response): void
    {
        $this->response = $response;
    }

    /**
     * Ensure body is empty and writable and return that.
     *
     * @return \Psr\Http\Message\StreamInterface
     * @throws \RuntimeException When the body is not writable or not empty somehow.
     */
    protected function getEmptyBody()
    {
        $body = $this->response->getBody();
        if (!$body->isWritable()) {
            throw new \RuntimeException('response body is not writeble');
        }
        if ($body->getSize() !== 0) {
            throw new \RuntimeException('response body is not empty');
        }

        return $body;
    }
}
