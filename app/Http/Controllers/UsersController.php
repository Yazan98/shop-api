<?php

namespace App\Http\Controllers;

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
            $newUserId = DB::table(User::$TABLE_NAME)->insertGetId(array(
                "name" => "dsljkfhnasdsksadldf",
                "image" => "dfsdfsefsesdffseasdfsefsefsef",
                "password" => "sdfkjlsdlasdfsdkfjslekfsef",
                "email" => "dfslefjlsasdsdfefsef",
                "gender" => "Malasdfsde",
                "age" => 15,
                "phone_number" => "sd;lfjsasdfsddef",
                "location_lat" => 15.2,
                "location_lng" => 1548.2,
                "location_name" => "6assdfd51asd"
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

    }

    public function getEntityById($id)
    {
        return DB::table(User::$TABLE_NAME)
            ->where('id', $id)
            ->lockForUpdate()
            ->get();
    }

    function getById(Request $request, Response $response)
    {
        // TODO: Implement getById() method.
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
