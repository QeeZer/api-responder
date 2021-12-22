<?php

namespace QeeZer\ApiResponder\Entity;

class DataEntity
{
    public $meta;

    public $data;

    /**
     * @param $meta
     * @param $data
     */
    public function __construct($meta, $data)
    {
        $this->meta = $meta;
        $this->data = $data;
    }

    /**
     * @param mixed $meta
     */
    public function setMeta($meta): void
    {
        $this->meta = $meta;
    }

    /**
     * @param mixed $data
     */
    public function setData($data): void
    {
        $this->data = $data;
    }
}