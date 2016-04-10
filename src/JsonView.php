<?php namespace Lit\Core;

use Lit\Core\Interfaces\IView;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Stream;

class JsonView implements IView
{
    protected $jsonOption = JSON_UNESCAPED_UNICODE;

    public function render(array $data, ResponseInterface $resp)
    {
        $body = $resp->getBody();
        if (!$body->isWritable() || $body->getSize() !== 0) {
            $body = new Stream('php://memory', 'wb+');
            $resp = $resp->withBody($body);
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
