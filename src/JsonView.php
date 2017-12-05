<?php namespace Lit\Core;

use Lit\Core\Interfaces\ViewInterface;
use Lit\Core\Traits\ViewTrait;
use Psr\Http\Message\ResponseInterface;

class JsonView implements ViewInterface
{
    use ViewTrait;

    protected $jsonOption = 0;

    /**
     * @param array $data
     * @return ResponseInterface
     */
    public function render(array $data = [])
    {
        $this->getEmptyBody()->write(json_encode($data, $this->jsonOption));

        return $this->response
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
