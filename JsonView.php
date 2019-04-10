<?php

declare(strict_types=1);

namespace Lit\Voltage;

use Psr\Http\Message\ResponseInterface;

class JsonView extends AbstractView
{
    const JSON_ROOT = self::class;
    protected $jsonOption = 0;

    /**
     * @param array $data
     * @return ResponseInterface
     */
    public function render(array $data = []): ResponseInterface
    {
        $jsonData = $data[self::JSON_ROOT] ?? $data;
        $this->getEmptyBody()->write(json_encode($jsonData, $this->jsonOption));

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
