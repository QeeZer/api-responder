<?php

namespace QeeZer\ApiResponder;

use QeeZer\ApiResponder\Contracts\ResourceInterface;

class DefaultResource implements ResourceInterface
{
    /** @var mixed $data */
    protected $data = [];

    /**
     * AbstractResource constructor.
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function toArray(): array
    {
        if (is_array($this->data)) {
            return $this->data;
        }

        return $this->data->toArray();
    }
}