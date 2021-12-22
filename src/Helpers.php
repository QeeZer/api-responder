<?php

namespace QeeZer\ApiResponder;

use QeeZer\ApiResponder\Entity\Contracts\ResponseEntityInterface;
use QeeZer\ApiResponder\Entity\ResponseEntity;
use Throwable;

class Helpers
{
    /**
     * responder.
     * demo: Helpers::api($responseEntity)->responder();
     * @param ResponseEntity $responseEntity
     * @return JsonResponseBuilder
     */
    public static function apiResponse(ResponseEntity $responseEntity): JsonResponseBuilder
    {
        return new JsonResponseBuilder($responseEntity);
    }

    /**
     * laravelExceptionRender.
     * @param $request
     * @param Throwable $throwable
     * @param callable|null $callback
     * @return JsonResponseBuilder
     */
    public static function laravelExceptionRender(
        $request,
        Throwable $throwable,
        callable $callback = null
    ): JsonResponseBuilder {
        if ($callback) {
            $throwable = $callback($request, $throwable);
        }

        return ResponderFactory::responseError($throwable);
    }
}