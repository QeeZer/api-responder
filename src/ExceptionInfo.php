<?php

namespace QeeZer\ApiResponder;

use Throwable;

class ExceptionInfo
{
    /** @var Throwable $exception */
    private $exception;

    /**
     * @param Throwable $exception
     */
    public function __construct(Throwable $exception)
    {
        $this->exception = $exception;
    }

    /**
     * @return array
     */
    public function getExceptionInfo(): array
    {
        return [
            'message' => $this->exception->getMessage(),
            'file' => $this->exception->getFile(),
            'line' => $this->exception->getLine(),
            'trace' => $this->exception->getTraceAsString(),
        ];
    }
}