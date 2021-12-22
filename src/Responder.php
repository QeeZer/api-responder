<?php

namespace QeeZer\ApiResponder;

use QeeZer\ApiResponder\Entity\ResponseEntity;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

trait Responder
{
    /**
     * response item.
     * @param $item
     * @param null $resource
     * @param array $meta
     * @return JsonResponseBuilder
     */
    public static function responseItem($item, $resource = null, array $meta = []): JsonResponseBuilder
    {
        return ResponderFactory::responseCollection($item, $resource, $meta);
    }

    /**
     * response collection.
     * @param $collection
     * @param null $resource
     * @param array $meta
     * @return JsonResponseBuilder
     */
    public static function responseCollection($collection, $resource = null, array $meta = []): JsonResponseBuilder
    {
        return ResponderFactory::responseCollection($collection, $resource, $meta);
    }

    /**
     * response paginate.
     * @param $paginator
     * @param null $resource
     * @param array $meta
     * @return JsonResponseBuilder
     */
    public static function responsePaginate($paginator, $resource = null, array $meta = []): JsonResponseBuilder
    {
        return ResponderFactory::responsePaginate($paginator, $resource, $meta);
    }

    /**
     * response data.
     * @param $data
     * @param array $meta
     * @param string $message
     * @return JsonResponseBuilder
     */
    public static function responseData(
        $data,
        array $meta = [],
        string $message = ResponseEntity::DEFAULT_SUCCESS_MESSAGE
    ): JsonResponseBuilder {
        return ResponderFactory::responseData($data, $meta, $message);
    }

    /**
     * response success.
     * @param string $message
     * @return JsonResponseBuilder
     */
    public static function responseSuccess(string $message = ResponseEntity::DEFAULT_SUCCESS_MESSAGE): JsonResponseBuilder
    {
        return ResponderFactory::responseSuccess($message);
    }

    /**
     * response fail.
     * @param string $message
     * @param array $data
     * @param int $errCode
     * @param int $httpStatusCode
     * @return JsonResponseBuilder
     */
    public static function responseFail(
        string $message = ResponseEntity::DEFAULT_FAIL_MESSAGE,
        array $data = [],
        int $errCode = ResponseEntity::DEFAULT_FAIL_CODE,
        int $httpStatusCode = Response::HTTP_OK
    ): JsonResponseBuilder {
        return ResponderFactory::responseFail($message, $data, $errCode, $httpStatusCode);
    }

    /**
     * response error.
     * @param Throwable $throwable
     * @return JsonResponseBuilder
     */
    public static function responseError(Throwable $throwable): JsonResponseBuilder
    {
        return ResponderFactory::responseError($throwable);
    }

    /**
     * response unauthorized.
     * @param string $message
     * @param int $httpStatusCode
     * @return JsonResponseBuilder
     */
    public static function responseUnauthorized(
        string $message = ResponseEntity::DEFAULT_UNAUTHORIZED,
        int $httpStatusCode = Response::HTTP_UNAUTHORIZED
    ): JsonResponseBuilder {
        return ResponderFactory::responseUnauthorized($message, $httpStatusCode);
    }

    /**
     * response created.
     * @param string $message
     * @return JsonResponseBuilder
     */
    public function responseCreated(string $message = ResponseEntity::DEFAULT_CREATED): JsonResponseBuilder
    {
        return ResponderFactory::responseCreated($message);
    }
}