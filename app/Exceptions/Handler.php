<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (ValidationException $e, $request) {
            return $this->sendValidationResponse($e->errors(), $request);
        });

        $this->renderable(function (NotFoundHttpException $e, $request) {
            return $this->sendResourceNotFoundResponse($request);
        });

        $this->renderable(function (DbErrorException $e, $request) {
            return $this->sendDbErrorResponse($e->getMessage(), $request);
        });
    }

    private function sendDbErrorResponse($errorMessage, $request): JsonResponse
    {
        return response()->json([
            'success' => false,
            'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
            'meta' => [
                'method' => $request->getMethod(),
                'endpoint' => $request->getRequestUri()
            ],
            'data' => [],
            'error' => $errorMessage,
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    private function sendResourceNotFoundResponse($request): JsonResponse
    {
        return response()->json([
            'success' => false,
            'code' => Response::HTTP_NOT_FOUND,
            'meta' => [
                'method' => $request->getMethod(),
                'endpoint' => $request->getRequestUri()
            ],
            'data' => [],
            'error' => 'The resource of the given ID was not found.',
        ], Response::HTTP_NOT_FOUND);
    }

    private function sendValidationResponse(array $validationErrors, Request $request): JsonResponse
    {
        $errors = $this->getValidationError($validationErrors);
            return response()->json([
                'success' => false,
                'code' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'meta' => [
                    'method' => $request->getMethod(),
                    'endpoint' => $request->getRequestUri()
                ],
                'data' => [],
                'error' => $errors,
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    private function getValidationError(array $validationErrors): array
    {
        $data = [];
        foreach ($validationErrors as $key => $value) {

            array_push($data, [
                'input' => $key,
                'messages' => $value[0]
            ]);
        }

        return $data;
    }
}
