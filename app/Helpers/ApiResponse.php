<?php

namespace App\Helpers;

class ApiResponse
{
    /**
     * Resposta de sucesso
     */
    public static function success($data = null, string $message = 'Operação realizada com sucesso', int $code = 200)
    {
        $response = [
            'success' => true,
            'message' => $message,
        ];

        if (!is_null($data)) {
            $response['data'] = $data;
        }

        return response()->json($response, $code);
    }

    /**
     * Resposta de erro
     */
    public static function error(string $message = 'Ocorreu um erro', int $code = 500, $errors = null)
    {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        if (!is_null($errors)) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $code);
    }
}
