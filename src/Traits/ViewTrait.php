<?php namespace Lit\Core\Traits;

use Psr\Http\Message\ResponseInterface;

trait ViewTrait
{
    /**
     * @var ResponseInterface
     */
    protected $response;

    /**
     *
     * @param ResponseInterface $response
     * @return $this
     */
    public function setResponse(ResponseInterface $response)
    {
        $this->response = $response;

        return $this;
    }

    /**
     * ensure body is empty and writable and return that
     *
     * @return \Psr\Http\Message\StreamInterface
     * @throws \RuntimeException
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
