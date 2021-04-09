<?php


namespace App\Http\Controllers;


use App\Models\Services\CategoryService;
use App\Models\ShopResponse;
use CrudControllerImplementation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

include("CrudControllerImplementation.php");

class CategoryController extends Controller implements CrudControllerImplementation
{

    function saveEntity(Request $request, Response $response)
    {
        try {
            $service = new CategoryService();
            $currentUserId = $service->saveEntity($request);
            $newInsertedUser = $service->getEntityById($currentUserId)->first();
            return ShopResponse::getSuccessResponse(ShopResponse::$DATA_CREATED_SUCCESS_RESPONSE, "", true, $newInsertedUser, $request);
        } catch (\Exception $exception) {
            return ShopResponse::getErrorResponse($exception, $request);
        }
    }

    function getAll(Request $request, Response $response)
    {
        try {
            $language = $this->getLanguageHeader($request);
            $service = new CategoryService();
            $users = $service->getAll($request, $language);
            if ($users != null) {
                return ShopResponse::getListResponse(ShopResponse::$SUCCESS_RESPONSE, "", true, $users, $request);
            } else {
                return ShopResponse::getNotFoundResponse(ShopResponse::$SUCCESS_RESPONSE, $request);
            }
        } catch (\Exception $exception) {
            echo $exception->getMessage();
            return ShopResponse::getErrorResponse($exception, $request);
        }
    }

    function getById(Request $request, Response $response, $id)
    {
        try {
            $user = new CategoryService();
            $currentUser = $user->getEntityById($id)->first();
            if ($user != null) {
                return ShopResponse::getSuccessResponse(ShopResponse::$SUCCESS_RESPONSE, "", true, $currentUser, $request);
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
        try {
            $userService = new CategoryService();
            $userService->deleteById($request);
            return ShopResponse::getSuccessResponse(ShopResponse::$SUCCESS_RESPONSE, "Data Deleted Successfully", true, null, $request);
        } catch (\Exception $exception) {
            echo $exception->getMessage();
            return ShopResponse::getErrorResponse($exception, $request);
        }
    }

    function deleteAll(Request $request, Response $response)
    {
        $userService = new CategoryService();
        $userService->deleteAll($request);
        return ShopResponse::getSuccessResponse(ShopResponse::$SUCCESS_RESPONSE, "Data Deleted Successfully", true, [], $request);
    }

    function getAllEnabledEntities(Request $request, Response $response)
    {
        try {
            $userService = new CategoryService();
            $allUsers = $userService->getAllEnabledEntities($request);
            if ($allUsers != null) {
                return ShopResponse::getListResponse(ShopResponse::$SUCCESS_RESPONSE, "", true, $allUsers, $request);
            } else {
                return ShopResponse::getNotFoundResponse(ShopResponse::$SUCCESS_RESPONSE, $request);
            }
        } catch (\Exception $exception) {
            return ShopResponse::getErrorResponse($exception, $request);
        }
    }

    function getAllDisabledEntities(Request $request, Response $response)
    {
        try {
            $userService = new CategoryService();
            $allUsers = $userService->getAllDisabledEntities($request);
            if ($allUsers != null) {
                return ShopResponse::getListResponse(ShopResponse::$SUCCESS_RESPONSE, "", true, $allUsers, $request);
            } else {
                return ShopResponse::getNotFoundResponse(ShopResponse::$SUCCESS_RESPONSE, $request);
            }
        } catch (\Exception $exception) {
            return ShopResponse::getErrorResponse($exception, $request);
        }
    }

    function getAllEnabledDisabledEntities(Request $request, Response $response, $status)
    {
        // TODO: Implement getAllEnabledDisabledEntities() method.
    }
}
