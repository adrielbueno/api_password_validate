<?php

namespace App\Core\Handlers\Exceptions;

use App\Core\Exceptions\DefaultException;
use App\Core\Handlers\Response\ResponseHandler as Response;
use Throwable;

class ExceptionHandler
{
    protected Throwable $exception;
    protected string $messageCode;
    protected string $statusCode;
    protected Response $response;
    protected array $data;

    public function __construct(
        Throwable $exception,
        string $messageCode = "",
        int $statusCode = 500,
        array $data = []
    ) {
        $this->exception = $exception;
        $this->messageCode = $messageCode;
        $this->statusCode = $statusCode;
        $this->response = new Response();
        $this->data = $data;
    }

    /**
     * Exibe uma mensagem com os detalhes de uma exception
     *
     * @return void
     */
    public function print(): void
    {
        $payload = $this->details();

        $this->response->printJson(
            $this->messageCode,
            $this->statusCode,
            $payload
        );
    }

    private function details(): array
    {
        $details["dateTime"] = date('y-m-d H:i:s');
        $details["details"] = [
            "file"    => $this->exception->getFile(),
            "line"    => $this->exception->getLine(),
            "message" => $this->exception->getMessage(),
            "code"    => $this->exception->getCode(),
            "trace"   => $this->exception->getTrace()
        ];

        if ($this->data !== []) {
            $details["data"] = $this->data;
        }

        if ($this->exception instanceof DefaultException) {
            $this->statusCode = 400;
            $details["mensagem"] = $this->chainMessages($this->exception);
        }

        return $details;
    }

    /**
     * Encadeia as mensagens de exceptions
     *
     * @param Throwable $thrown
     * @return string
     */
    private function chainMessages(Throwable $thrown): string
    {
        $message = trim($thrown->getMessage());
        if ($thrown->getPrevious() !== null) {
            if (in_array(substr($message, -1), ['.', '!'])) {
                $message = substr($message, 0, -1);
            }
            $message .= ". "  . $this->chainMessages($thrown->getPrevious());
        }

        if (!in_array(substr($message, -1), ['.', '!'])) {
            $message .= ".";
        }

        return trim($message);
    }
}
