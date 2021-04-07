<?php

namespace App\Http\Controllers;

use App\Exceptions\BadInformationException;
use App\Models\Services\UserService;
use App\Models\ShopResponse;
use App\Models\User;
use CrudControllerImplementation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

include("CrudControllerImplementation.php");

class UsersController extends Controller implements CrudControllerImplementation
{

    function saveEntity(Request $request, Response $response)
    {
        try {
            $userService = new UserService();
            $currentUserId = $userService->saveEntity($request);
            if ($currentUserId == User::$USER_NOT_INSERTED) {
                return ShopResponse::getErrorResponseWithoutException($request, "Something Error User Not Saved", ShopResponse::$INTERNAL_ERROR_RESPONSE);
            } else {
                $newInsertedUser = self::getEntityById($currentUserId);
                return ShopResponse::getSuccessResponse(ShopResponse::$DATA_CREATED_SUCCESS_RESPONSE, "", true, $newInsertedUser, $request);
            }
        } catch (\Exception $exception) {
            return ShopResponse::getErrorResponse($exception, $request);
        }
    }

    function getAll(Request $request, Response $response)
    {
        try {
            $allUsers = DB::table(User::$TABLE_NAME)->get();
            if ($allUsers != null) {
                return ShopResponse::getListResponse(ShopResponse::$SUCCESS_RESPONSE, "", true, $allUsers, $request);
            } else {
                return ShopResponse::getNotFoundResponse(ShopResponse::$SUCCESS_RESPONSE, $request);
            }
        } catch (\Exception $exception) {
            echo $exception->getMessage();
            return ShopResponse::getErrorResponse($exception, $request);
        }
    }

    public function getEntityById($id)
    {
        return DB::table(User::$TABLE_NAME)
            ->where('id', $id)
            ->lockForUpdate()
            ->get();
    }

    function getById(Request $request, Response $response, $id)
    {
        try {
            $user = self::getEntityById($id)->first();
            if ($user != null) {
                return ShopResponse::getSuccessResponse(ShopResponse::$SUCCESS_RESPONSE, "", true, $user, $request);
            } else {
                return ShopResponse::getNotFoundResponse(ShopResponse::$SUCCESS_RESPONSE, $request);
            }
        } catch (\Exception $exception) {
            echo $exception->getMessage();
            return ShopResponse::getErrorResponse($exception, $request);
        }
    }

    function deleteById(Request $request, Response $response)
    {
        // TODO: Implement deleteById() method.
    }

    function deleteAll(Request $request, Response $response)
    {
        // TODO: Implement deleteAll() method.
    }

    function getAllEnabledEntities(Request $request, Response $response)
    {
       return self::getAllEnabledDisabledEntities($request, $response, true);
    }

    function getAllDisabledEntities(Request $request, Response $response)
    {
        return self::getAllEnabledDisabledEntities($request, $response, false);
    }

    function getAllEnabledDisabledEntities(Request $request, Response $response, $status)
    {
        try {
            $allUsers = DB::table(User::$TABLE_NAME)->where(User::$IS_ENABLED, '=', $status)->get();
            if ($allUsers != null) {
                return ShopResponse::getListResponse(ShopResponse::$SUCCESS_RESPONSE, "", true, $allUsers, $request);
            } else {
                return ShopResponse::getNotFoundResponse(ShopResponse::$SUCCESS_RESPONSE, $request);
            }
        } catch (\Exception $exception) {
            echo $exception->getMessage();
            return ShopResponse::getErrorResponse($exception, $request);
        }
    }
}
