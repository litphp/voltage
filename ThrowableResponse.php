<?php

declare(strict_types=1);

namespace Lit\Voltage;

use Lit\Voltage\Interfaces\ThrowableResponseInterface;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * Standard custom exception which contains a response.
 */
class ThrowableResponse extends \Exception implements ThrowableResponseInterface
{
    /**
     * @var ResponseInterface
     */
    protected $response;

    /**
     * @param ResponseInterface $response The response to include in the exception.
     * @param Throwable|null    $previous The previous throwable used for the exception chaining.
     * @param string            $message  The Exception message to throw.
     * @param integer           $code     The Exception code.
     */
    public function __construct(
        ResponseInterface $response,
        Throwable $previous = null,
        string $message = "",
        int $code = 0
    ) {
        parent::__construct($message, $code, $previous);
        $this->response = $response;
    }

    /**
     * Create a ThrowableResponse with no other exception information
     *
     * @param ResponseInterface $response The response.
     * @return ThrowableResponse
     */
    public static function of(ResponseInterface $response)
    {
        return new static($response);
    }

    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }
}
