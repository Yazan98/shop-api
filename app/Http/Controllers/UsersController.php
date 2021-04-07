<?php

namespace App\Http\Controllers;

use CrudControllerImplementation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\ShopResponse;

include("CrudControllerImplementation.php");

class UsersController extends Controller implements CrudControllerImplementation {

    function saveEntity(Request $request, Response $response) {
        return ShopResponse::getSuccessResponse(ShopResponse::$SUCCESS_RESPONSE, "", true, [
            "sdfsdfsdfsdf",
            "sdfsdfsdfsdf",
            "sdfsdfsdfsdf",
            "sdfsdfsdfsdf",
            "sdfsdfsdfsdf",
            "sdfsdfsdfsdf",
            "sdfsdfsdfsdf",
            "sdfsdfsdfsdf",
            "sdfsdfsdfsdf",
            "sdfsdfsdfsdf",
            "sdfsdfsdfsdf",
            "sdfsdfsdfsdf",
            "sdfsdfsdfsdf"
        ], $request);
    }

    function getAll(Request $request, Response $response)
    {
        return ShopResponse::getSuccessResponse(ShopResponse::$SUCCESS_RESPONSE, "", true, [
            "sdfsdfsdfsdf",
            "sdfsdfsdfsdf",
            "sdfsdfsdfsdf",
            "sdfsdfsdfsdf",
            "sdfsdfsdfsdf",
            "sdfsdfsdfsdf",
            "sdfsdfsdfsdf",
            "sdfsdfsdfsdf",
            "sdfsdfsdfsdf",
            "sdfsdfsdfsdf",
            "sdfsdfsdfsdf",
            "sdfsdfsdfsdf",
            "sdfsdfsdfsdf"
        ], $request);
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
