<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function res($message, $code = 200)
    {
        return response()->json($message, $code);
    }

    public function resException($e, $code = 200, $message = "something wrong") {
        return $this->res([
            'message' => $message,
            'error' => $e->getMessage()
        ], $code);
    }
}
