<?php

namespace App\Http\Traits;

trait HttpResponse
{
    protected function error($data, $message, $code = 401)
    {
        return response()->json([
            'status' => 'An error has been occurred..',
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    protected function success($data = null, $message = null, $code = 200)
    {
        return response()->json([
            'status' => 'Request was successful',
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
}
