<?php

namespace QeeZer\ApiResponder\Entity;

class ResponseEntity
{
    public const SUCCESS_CODE = 0;

    public const DEFAULT_FAIL_CODE = 1;

    public const DEFAULT_SUCCESS_MESSAGE = 'ok';

    public const DEFAULT_FAIL_MESSAGE = 'fail';

    public const DEFAULT_ERROR_MESSAGE = 'system error';

    public const DEFAULT_UNAUTHORIZED = 'unauthorized';

    public const DEFAULT_CREATED = 'created';

    /** @var int $code */
    public $code;

    /** @var string $message */
    public $message;

    /** @var DataEntity $data */
    public $data;

    /**
     * @param int $code
     * @param string $message
     * @param mixed $data
     */
    public function __construct(int $code, string $message, DataEntity $data)
    {
        $this->code = $code;
        $this->message = $message;
        $this->data = $data;
    }

    /**
     * @param int $code
     */
    public function setCode(int $code): void
    {
        $this->code = $code;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    /**
     * @param DataEntity|null $data
     */
    public function setData(DataEntity $data = null): void
    {
        $this->data = $data;
    }
}