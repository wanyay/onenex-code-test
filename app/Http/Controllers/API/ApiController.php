<?php

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class ApiController extends Controller
{
    /**
     * response data.
     *
     * @var mixed
     */
    protected mixed $data;

    /**
     * response error data
     *
     * @var array
     */
    protected array $errors = [];

    /**
     *  total of data
     *
     * @var ?int
     */
    protected ?int $total = null;

    /**
     * limit
     *
     * @var ?int
     */
    protected ?int $limit = null;

    /**
     * offset
     *
     * @var ?int
     */
    protected ?int $offset = null;

    /**
     *  send the json response.
     *
     * @param $result
     * @param int $code
     * @return JsonResponse
     */
    public function sendResponse($result, int $code): JsonResponse
    {
        $response = [
            'success' => true,
            'code' => $code,
            'meta' => $this->getMeta(),
            'data' => $result,
            'errors' => $this->getErrors(),
            'duration' => $this->getDuration()
        ];

        return response()->json($response, $code);
    }

    /**
     * error response.
     *
     * @param $error
     * @param int $code
     * @return JsonResponse
     */
    public function sendError($error, int $code = 404): JsonResponse
    {
        $response = [
            'success' => false,
            'code' => $code,
            'meta' => [
                'method' => request()->getMethod(),
                'endpoint' => request()->getRequestUri()
            ],
            'data' => [],
            'error' => $error,
            'duration' => $this->getDuration()
        ];

        return response()->json($response);
    }

    /**
     * @return object|array
     */
    public function getErrors(): object|array
    {
        $errors = $this->errors;
        if (empty($errors)) {
            $errors = (object)$errors;
        }

        return $errors;
    }

    /**
     * @return float
     */
    public function getDuration(): float
    {
        return (float) sprintf("%.3f", (microtime(true) - LARAVEL_START));
    }

    /**
     * @return array
     */
    public function getMeta(): array
    {
        $meta = [
            'method' => request()->getMethod(),
            'endpoint' => request()->getRequestUri()
        ];

        if (!is_null($this->limit)) {
            $meta['limit'] = $this->limit;
        }

        if (!is_null($this->offset)) {
            $meta['offset'] = $this->offset;
        }

        if (!is_null($this->total)) {
            $meta['total'] = $this->total;
        }

        return $meta;
    }
}
