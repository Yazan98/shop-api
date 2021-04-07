<?php

namespace App\Http\Controllers;

use App\Models\ShopResponse;
use App\Models\User;
use CrudControllerImplementation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

include("CrudControllerImplementation.php");

class UsersController extends Controller implements CrudControllerImplementation
{

    function saveEntity(Request $request, Response $response)
    {
        try {
            $newUserId = DB::table(User::$TABLE_NAME)->insertGetId(array(
                "name" => $request->input('name'),
                "image" => $request->input('image'),
                "password" => Hash::make($request->input('password')),
                "email" => $request->input('email'),
                "gender" => $request->input('gender'),
                "age" => $request->input('age'),
                "phone_number" => $request->input('phone_number'),
                "location_lat" => $request->input('location_lat'),
                "location_lng" => $request->input('location_lng'),
                "location_name" => $request->input('location_name')
            ));
            $newInsertedUser = self::getEntityById($newUserId);
            return ShopResponse::getSuccessResponse(ShopResponse::$DATA_CREATED_SUCCESS_RESPONSE, "", true, $newInsertedUser, $request);
        } catch (\Exception $exception) {
            echo $exception->getMessage();
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
        // TODO: Implement getAllEnabledEntities() method.
    }

    function getAllDisabledEntities(Request $request, Response $response)
    {
        // TODO: Implement getAllDisabledEntities() method.
    }
}
