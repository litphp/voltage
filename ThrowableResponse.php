<?php

declare(strict_types=1);

namespace Lit\Voltage;

use Lit\Voltage\Interfaces\ThrowableResponseInterface;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class ThrowableResponse extends \Exception implements ThrowableResponseInterface
{
    /**
     * @var ResponseInterface
     */
    protected $response;

    public function __construct(ResponseInterface $response, Throwable $previous = null, $message = "", $code = 0)
    {
        parent::__construct($message, $code, $previous);
        $this->response = $response;
    }

    public static function of(ResponseInterface $response)
    {
        return new static($response);
    }

    /**
     * @return ResponseInterface
     */
    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }
}
