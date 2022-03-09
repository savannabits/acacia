<?php

namespace Savannabits\Acacia\Helpers;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\HeaderBag;

class ApiResponse
{
    private int $code = 200;
    private array|HeaderBag $headers=[];
    private mixed $payload=[];
    private bool $success=true;
    private string $message="Request Successful.";

    /**
     * The operation was successful.
     * @return ApiResponse
     */
    public function success(): static
    {
        $this->success = true;
        if (!$this->code) {
            $this->code = 200;
        }
        return $this;
    }

    /**
     * The operation was not successful, we are returning an error
     * @return ApiResponse
     */
    public function failed(): static
    {
        $this->success = false;
        if (!$this->code) {
            $this->code = 500;
        }
        return $this;
    }

    /**
     * set the message to respond with
     * @param string $message
     * @return ApiResponse
     */
    public function message(string $message=""): static
    {
        $this->message = $message;
        return $this;
    }

    /**
     * Set the payload to the response
     * @param $payload | The data to send to the client
     * @return ApiResponse
     */
    public function payload($payload): static
    {
        $this->payload = $payload;
        return $this;
    }

    /**
     * Set the response code according to the status of the response
     * @param int $httpCode
     * @return ApiResponse
     */
    public function code(int $httpCode = 200): static
    {
        $this->code = $httpCode;
        return $this;
    }

    /**
     * Set custom response headers if necessary
     * @param array|HeaderBag $headers
     * @return ApiResponse
     */
    public function headers(array|HeaderBag $headers): static
    {
        $this->headers = $headers;
        return $this;
    }
    public function send(): JsonResponse
    {
        return response()->json([
            "success" => $this->success,
            "message" => $this->message,
            "payload" => $this->payload,
        ],$this->code)->withHeaders($this->headers);
    }
}