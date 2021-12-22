<?php

namespace QeeZer\ApiResponder\Contracts;

interface ResourceInterface
{
    /**
     * toArray()
     * @return array
     */
    public function toArray(): array;
}