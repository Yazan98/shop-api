<?php

namespace App\Models;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class ShopResponse
{

    public static $JSON_CONTENT_TYPE = "application/json";
    public static $SUCCESS_RESPONSE = "Success";
    public static $BAD_REQUEST_RESPONSE = "BadRequest";
    public static $UN_AUTH_RESPONSE = "UnAuth";
    public static $NOT_FOUND_RESPONSE = "NotFound";
    public static $NO_CONTENT_RESPONSE = "NoContent";
    public static $DATA_CREATED_SUCCESS_RESPONSE = "Created";

    static function getSuccessResponse($code, $message, $status, $data, Request $request)
    {
        $filteredResponseCode = self::getFilteredResponseCode($code);
        $filteredMessage = self::getFilteredMessage($message);
        $currentDate = new Datetime();

        return response([
            "code" => $filteredResponseCode,
            "message" => $filteredMessage,
            "status" => $status,
            "path" => $request->fullUrl(),
            "timestamp" => $currentDate->format('U') + 0,
            "data" => $data
        ], $filteredResponseCode)->header('Content-Type', self::$JSON_CONTENT_TYPE);
    }

    static function getErrorResponse(\Exception $exception, Request $request) {
        $currentDate = new Datetime();
        $responseCode = self::getFilteredResponseCode(self::$NO_CONTENT_RESPONSE);
        return response([
            "code" =>$responseCode ,
            "message" => "Failed",
            "status" => false,
            "path" => $request->fullUrl(),
            "timestamp" => $currentDate->format('U') + 0,
            "error" => $exception->getCode(),
            "errorMessage" => $exception->getMessage(),
            "stackTrace"=> $exception->getTraceAsString()
        ], $responseCode)->header('Content-Type', self::$JSON_CONTENT_TYPE);
    }

    public static function getFilteredResponseCode($code)
    {
        switch ($code) {
            case ShopResponse::$SUCCESS_RESPONSE:
                return Response::HTTP_OK;
            case self::$NOT_FOUND_RESPONSE:
                return Response::HTTP_NOT_FOUND;
            case self::$BAD_REQUEST_RESPONSE:
                return Response::HTTP_BAD_REQUEST;
            case self::$NO_CONTENT_RESPONSE:
                return Response::HTTP_NO_CONTENT;
            case self::$UN_AUTH_RESPONSE:
                return Response::HTTP_UNAUTHORIZED;
            case self::$DATA_CREATED_SUCCESS_RESPONSE:
                return Response::HTTP_CREATED;
            default:
                return Response::HTTP_INTERNAL_SERVER_ERROR;
        }
    }

    public static function getFilteredMessage($message) {
        if (empty($message)) {
            return "Data Found";
        } else {
            return $message;
        }
    }

}
