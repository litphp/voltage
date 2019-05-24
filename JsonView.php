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
        $jsonData = array_key_exists(static::JSON_ROOT, $data) ? $data[static::JSON_ROOT] : $data;
        /** @var string $jsonString */
        $jsonString = json_encode($jsonData, $this->jsonOption);
        assert(json_last_error() === JSON_ERROR_NONE);
        $this->getEmptyBody()->write($jsonString);

        return $this->response
            ->withHeader('Content-Type', 'application/json');
    }

    public function renderJson($value): ResponseInterface
    {
        return $this->render([static::JSON_ROOT => $value]);
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
