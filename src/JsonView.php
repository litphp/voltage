<?php namespace Lit\Core;

use Lit\Core\Interfaces\IView;
use Psr\Http\Message\ResponseInterface;

class JsonView implements IView
{
    protected $jsonOption = JSON_UNESCAPED_UNICODE;

    /**
     * @param array $data
     * @param ResponseInterface $resp
     * @return ResponseInterface
     */
    public function render(array $data, ResponseInterface $resp)
    {
        $body = $resp->getBody();
        if (!$body->isWritable()) {
            throw new \Exception('response body is not writeble');
        }
        if ($body->getSize() !== 0) {
            throw new \Exception('response body is not empty');
        }

        $body->write(json_encode($data, $this->jsonOption));

        return $resp
            ->withHeader('Content-Type', 'application/json');
    }

    /**
     * @return int
     */
    public function getJsonOption()
    {
        return $this->jsonOption;
    }

    /**
     *
     * @param int $jsonOption
     * @return $this
     */
    public function setJsonOption($jsonOption)
    {
        $this->jsonOption = $jsonOption;

        return $this;
    }
}
