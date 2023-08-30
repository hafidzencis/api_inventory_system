<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function sendResponseSuccess($message){
        $response = [
            'code' => 200,
            'status' => 'OK',
            'data' => $message
        ];

        return response()->json($response,200);
    }

    public function sendResponseBadRequest($messageError ){
        $response = [
            'code' => 400,
            'status' => 'BAD_REQUEST'
        ];

        if (! empty($messageError)) {
            $response['error'] = $messageError;
        }

        return response()->json($response,400);
    }

    public function sendResponseNotFound($messageError){
        $response = [
            'code' => 404,
            'status' => 'NOT_FOUND'
        ];

        if (!empty($messageError)) {
            $response['error'] = $messageError;
        }

        return response()->json($response,404);
    }
}
