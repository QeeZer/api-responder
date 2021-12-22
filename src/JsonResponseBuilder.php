<?php

namespace QeeZer\ApiResponder;

use QeeZer\ApiResponder\Entity\ResponseEntity;
use Symfony\Component\HttpFoundation\Response;

class JsonResponseBuilder
{
    /** @var JsonResponse $jsonResponse */
    private $jsonResponse;

    /**
     * @param ResponseEntity $data
     * @param int $status
     * @param array $headers
     * @param int|string $options
     */
    public function __construct(
        ResponseEntity $data,
        int $status = Response::HTTP_OK,
        array $headers = [],
        $options = JsonResponse::DEFAULT_ENCODING_OPTIONS
    )
    {
        $this->jsonResponse = new JsonResponse($data, $status, $headers, $options);
    }

    /**
     * @param $data
     * @return $this
     */
    public function setData($data): self
    {
        $this->jsonResponse->setData($data);

        return $this;
    }

    /**
     * @param int $status
     * @return $this
     */
    public function setStatus(int $status): self
    {
        $this->jsonResponse->setStatusCode($status);

        return $this;
    }

    /**
     * @param array $headers
     * @return $this
     */
    public function setHeaders(array $headers): self
    {
        $this->jsonResponse->withHeaders($headers);

        return $this;
    }

    /**
     * @param $options
     * @return $this
     */
    public function setOptions($options): self
    {
        $this->jsonResponse->setEncodingOptions($options);

        return $this;
    }

    /**
     * send.
     * @return JsonResponse
     */
    public function send(): JsonResponse
    {
        return $this->jsonResponse->send();
    }

    /**
     * responder.
     * @return JsonResponse
     */
    public function responder(): JsonResponse
    {
        return $this->jsonResponse;
    }

    /**
     * render.
     * @return string
     */
    public function __toString(): string
    {
        return $this->jsonResponse->getContent();
    }
}