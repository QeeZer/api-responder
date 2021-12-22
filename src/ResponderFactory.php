<?php

namespace QeeZer\ApiResponder;

use QeeZer\ApiResponder\Contracts\BusinessException;
use QeeZer\ApiResponder\Contracts\NondisclosureException;
use QeeZer\ApiResponder\Entity\ResponseEntity;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class ResponderFactory
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
        if ($resource) {
            $resourceInstance = new $resource($item);
            $item = $resourceInstance->toArray();
        }

        return Helpers::apiResponse(ResponseEntityFactory::responseEntity($item, $meta));
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
        if ($resource) {
            $result = $collection->map(function ($item) use ($resource) {
                $resourceInstance = new $resource($item);
                return $resourceInstance->toArray();
            });
        } else {
            $result = &$collection;
        }

        return Helpers::apiResponse(ResponseEntityFactory::responseEntity($result, $meta));
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
        $paginated = $paginator->toArray();
        $links = [
            'first_page_url' => $paginated['first_page_url'] ?? null,
            'last_page_url' => $paginated['last_page_url'] ?? null,
            'prev_page_url' => $paginated['prev_page_url'] ?? null,
            'next_page_url' => $paginated['next_page_url'] ?? null,
        ];

        $pagination = $paginated;
        unset(
            $pagination['links'],
            $pagination['data'],
            $pagination['first_page_url'],
            $pagination['last_page_url'],
            $pagination['prev_page_url'],
            $pagination['next_page_url']
        );

        if ($resource) {
            $result = $paginator->getCollection()->map(function ($item) use ($resource) {
                $resourceInstance = new $resource($item);
                return $resourceInstance->toArray();
            });
        } else {
            $result = $paginator->items();
        }

        return Helpers::apiResponse(ResponseEntityFactory::responseEntity($result, array_merge($meta, [
            'pagination' => $pagination,
            'links' => $links,
        ])));
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
        return Helpers::apiResponse(ResponseEntityFactory::responseEntity($data, $meta, $message));
    }

    /**
     * response success.
     * @param string $message
     * @return JsonResponseBuilder
     */
    public static function responseSuccess(string $message = ResponseEntity::DEFAULT_SUCCESS_MESSAGE): JsonResponseBuilder
    {
        return Helpers::apiResponse(ResponseEntityFactory::responseEntity(null, null, $message));
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
        return Helpers::apiResponse(ResponseEntityFactory::responseEntity($data, null, $message, $errCode))
            ->setStatus($httpStatusCode);
    }

    /**
     * response error.
     * @param Throwable $throwable
     * @return JsonResponseBuilder
     */
    public static function responseError(Throwable $throwable): JsonResponseBuilder
    {
        $data = null;

        if (function_exists('env')) {
            if (env('APP_ENV') === 'local' || env('APP_DEBUG') === true) {
                $data = (new ExceptionInfo($throwable))->getExceptionInfo();
            }
        }

        $errCode = $throwable->getCode() === ResponseEntity::SUCCESS_CODE
            ? ResponseEntity::DEFAULT_FAIL_CODE
            : $throwable->getCode();

        $message = $throwable instanceof NondisclosureException
            ? ResponseEntity::DEFAULT_ERROR_MESSAGE
            : $throwable->getMessage();

        $result = Helpers::apiResponse(ResponseEntityFactory::responseEntity(
            $data,
            null,
            $message,
            $errCode
        ));

        if (!$throwable instanceof BusinessException) {
            $result->setStatus(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $result;
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
        return Helpers::apiResponse(ResponseEntityFactory::responseEntity(
            null,
            null,
            $message,
            Response::HTTP_UNAUTHORIZED
        ))->setStatus($httpStatusCode);
    }

    /**
     * response created.
     * @param string $message
     * @return JsonResponseBuilder
     */
    public static function responseCreated(string $message = ResponseEntity::DEFAULT_CREATED): JsonResponseBuilder
    {
        return Helpers::apiResponse(ResponseEntityFactory::responseEntity(null, null, $message))
            ->setStatus(Response::HTTP_CREATED);
    }

    /**
     * basic http response.
     * @param string $message
     * @param int $statusCode
     * @return JsonResponseBuilder
     */
    public static function responseHttp(string $message = '', int $statusCode = Response::HTTP_OK): JsonResponseBuilder
    {
        return Helpers::apiResponse(
            ResponseEntityFactory::responseEntity(null, null, $message, $statusCode)
        )->setStatus($statusCode);
    }
}