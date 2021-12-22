<?php

namespace QeeZer\ApiResponder;

use QeeZer\ApiResponder\Entity\DataEntity;
use QeeZer\ApiResponder\Entity\ResponseEntity;

class ResponseEntityFactory
{
    /**
     * DataEntity.
     * @param mixed $data
     * @param mixed $meta
     * @return DataEntity
     */
    public static function dataEntity($data = null, $meta = null): DataEntity
    {
        return new DataEntity(empty($meta) ? null : $meta, empty($data) ? null : $data);
    }

    /**
     * ResponseEntity.
     * @param mixed $data
     * @param mixed $meta
     * @param string $message
     * @param int $code
     * @return ResponseEntity
     */
    public static function responseEntity(
        $data = null,
        $meta = null,
        string $message = ResponseEntity::DEFAULT_SUCCESS_MESSAGE,
        int $code = ResponseEntity::SUCCESS_CODE
    ): ResponseEntity
    {
        return new ResponseEntity($code, $message, self::dataEntity($data, $meta));
    }
}