<?php

namespace App\Helpers;

use App\Models\Response;

class ResponseHelper
{
    /**
     *  2xx - Success
     */
    public static $HTPP_200 = ['200', 'OK'];
    public static $HTPP_201 = ['201', 'Created'];

    /**
     *  4xx - Client errors
     */
    public static $HTPP_400 = ['400', 'Bad Request'];
    public static $HTPP_401 = ['401', 'Unauthorized'];
    public static $HTPP_404 = ['404', 'Not Found'];
    public static $HTPP_408 = ['201', 'Request Timeout'];

    /**
     *  5xx - Server errors
     */
    public static $HTPP_500 = ['500', 'Internal Server Error'];

    /**
     *  Method: JSON Body response template builder
     */
    public static function ResponseBuilder($data, $code, $status, $msg, $token) {
        $response = new Response;
        $response->data = $data;
        $response->code = $code;
        $response->status = $status;
        $response->message = $msg;
        $response->token = $token;
        return $response;
    }
}