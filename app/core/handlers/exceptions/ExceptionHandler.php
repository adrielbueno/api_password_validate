<?php

namespace App\Core\Handlers\Exceptions;

use App\Core\Exceptions\DefaultException;
use App\Core\Handlers\Response\ResponseHandler as Response;
use Throwable;

class ExceptionHandler
{
    protected Throwable $exception;
    protected string $statusCode;
    protected Response $response;
    protected array $data;

    public function __construct(
        Throwable $exception,
        int $statusCode = 500,
        array $data = []
    ) {
        $this->exception = $exception;
        $this->statusCode = $statusCode;
        $this->response = new Response();
        $this->data = $data;
    }

    /**
     * Displays a message with the details of an exception
     *
     * @return void
     */
    public function print(): void
    {
        $payload = $this->details();

        $this->response->printJson(
            $this->statusCode,
            $payload
        );
    }

    /**
     * Returns the details of an exception
     *
     * @return array
     */
    private function details(): array
    {
        $details["dateTime"] = date('y-m-d H:i:s');
        $details["details"] = [
            "file"    => $this->exception->getFile(),
            "line"    => $this->exception->getLine(),
            "code"    => $this->exception->getCode(),
            "trace"   => $this->exception->getTrace()
        ];

        if ($this->data !== []) {
            $details["data"] = $this->data;
        }

        if ($this->exception instanceof DefaultException) {
            $this->statusCode = 400;
        }

        return $details;
    }
}
