<?php

namespace QeeZer\ApiResponder;

use Symfony\Component\HttpFoundation\HeaderBag;
use Symfony\Component\HttpFoundation\JsonResponse as BaseJsonResponse;
use Symfony\Component\HttpFoundation\Response;

class JsonResponse extends BaseJsonResponse
{
    public const DEFAULT_ENCODING_OPTIONS = JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT
        | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES;

    /**
     * Constructor.
     * @param null $data
     * @param int $status
     * @param array $headers
     * @param int|string $options
     */
    public function __construct(
        $data = null,
        int $status = Response::HTTP_OK,
        array $headers = [],
        $options = self::DEFAULT_ENCODING_OPTIONS
    ) {
        $this->encodingOptions = $options;

        parent::__construct($data, $status, $headers);
    }

    /**
     * Set a header on the Response.
     * @param string $key
     * @param string|array $values
     * @param bool $replace
     * @return $this
     */
    public function header(string $key, $values, bool $replace = true): JsonResponse
    {
        $this->headers->set($key, $values, $replace);

        return $this;
    }

    /**
     * Add an array of headers to the response.
     * @param $headers
     * @return $this
     */
    public function withHeaders($headers): JsonResponse
    {
        if ($headers instanceof HeaderBag) {
            $headers = $headers->all();
        }

        foreach ($headers as $key => $value) {
            $this->headers->set($key, $value);
        }

        return $this;
    }
}