<?php

namespace App\Http\Traits;

trait HttpResponse
{
    protected function success($data = null, $message = null, $code = 200)
    {
        return response()->json([
            'status' => $code,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    protected function created($data, $message = null, $code = 201)
    {
        return response()->json([
            'status' => $code,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    protected function notFound($message = null, $code = 404)
    {
        return response()->json([
            'status' => $code,
            'message' => $message ?? 'Not Found',
        ], $code);
    }

    protected function error($data, $message, $code = 401)
    {
        return response()->json([
            'status' => 'An error has been occurred..',
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    protected function internalError($message)
    {
        return response()->json([
            'status' => 'Internal Server Error',
            'message' => $message,
        ], 500);
    }

    protected function validationError($errors)
    {
        return $this->error('Validation Error', $errors, 422);
    }

    protected function unauthorizedAdmin()
    {
        return response()->json([
            'status' => 'Unauthorized',
            'message' => 'You are not authorized to access this resource',
        ], 401);
    }
}
