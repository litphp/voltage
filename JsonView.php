<?php

declare(strict_types=1);

namespace Lit\Voltage;

use Psr\Http\Message\ResponseInterface;

/**
 * A simple view class doing json_encode for payloads.
 */
class JsonView extends AbstractView
{
    const JSON_ROOT = self::class;
    protected $jsonOption = 0;

    /**
     * {@inheritDoc}
     *
     * You may use renderJson which receive any type instead of this.
     *
     * @param array $data Payload. If JsonView::JSON_ROOT exist in payload, it will be used instead of whole payload.
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

    /**
     * Render method that receives any type of payload.
     *
     * @param mixed $value The payload to be outputed.
     * @return ResponseInterface
     */
    public function renderJson($value): ResponseInterface
    {
        return $this->render([static::JSON_ROOT => $value]);
    }

    /**
     * @return integer
     */
    public function getJsonOption(): int
    {
        return $this->jsonOption;
    }

    /**
     * @param integer $jsonOption The new json option.
     * @return $this
     */
    public function setJsonOption(int $jsonOption)
    {
        $this->jsonOption = $jsonOption;
        return $this;
    }
}
