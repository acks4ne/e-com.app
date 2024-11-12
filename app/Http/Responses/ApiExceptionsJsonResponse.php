<?php

namespace App\Http\Responses;

use Throwable;

class ApiExceptionsJsonResponse extends CustomJsonResponse
{
    /**
     * @param Throwable $e
     * @param array     $config
     * @param array     $body
     */
    public function __construct(Throwable $e, array $config, array $body)
    {
        $data = $this->makeApiResponse($e, $config, $body);

        parent::__construct(...$data);
    }

    /**
     * @param Throwable $e
     * @param array     $config
     * @param array     $body
     * @return array
     */
    private function makeApiResponse(Throwable $e, array $config, array $body): array
    {
        return [
            'body' => $this->buildResponseBody($e, $body),
            'status' => $config['status'] ?? 500,
        ];
    }

    /**
     * @param Throwable $e
     * @param array     $bodyConfig
     * @return array
     */
    private function buildResponseBody(Throwable $e, array $bodyConfig): array
    {
        $body = [];

        foreach ($bodyConfig as $key => $value) {
            if ($key === 'exception') {
                $body = array_merge($body, $this->getExceptionDetails($e, $value));
            } else {
                $body[$key] = $value;

                if (str_contains($body[$key], 'api.')) {
                    $path = str_replace('/', '.', request()->path());

                    $body[$key] = str_replace('api.', $path . '.', $body[$key]);
                }
            }
        }

        if (app()->isLocal()) {
            $body = array_merge($body, [
                'type' => get_class($e),
                'code' => $e->getCode(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTrace(),
            ]);
        }

        return $body;
    }

    /**
     * @param Throwable $e
     * @param array     $exceptionConfig
     * @return array
     */
    private function getExceptionDetails(Throwable $e, array $exceptionConfig): array
    {
        $details = [];
        foreach ($exceptionConfig as $k => $v) {
            $value = method_exists(get_class($e), $v) ? $e->{$v}() : "Method is not defined";

            $details[$k] = empty($value) ? "Message is not defined" : $value;
        }

        return $details;
    }
}
