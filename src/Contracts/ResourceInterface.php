<?php

namespace QeeZer\ApiResponder\Entity\Contracts;

interface ResourceInterface
{
    /**
     * toArray()
     * @return array
     */
    public function toArray(): array;
}