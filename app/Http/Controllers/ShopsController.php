<?php


namespace App\Http\Controllers;

use App\Models\GeneralApiKeys;
use App\Models\Services\ShopItemService;
use App\Models\Services\ShopsService;
use App\Models\ShopResponse;
use CrudControllerImplementation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

include("CrudControllerImplementation.php");

class ShopsController extends Controller implements CrudControllerImplementation
{

    function saveEntity(Request $request, Response $response)
    {
        try {
            $service = new ShopsService();
            $currentUserId = $service->saveEntity($request);
            $newInsertedUser = $service->getEntityById($currentUserId)->first();
            return ShopResponse::getSuccessResponse(ShopResponse::$DATA_CREATED_SUCCESS_RESPONSE, "", true, $newInsertedUser, $request);
        } catch (\Exception $exception) {
            return ShopResponse::getErrorResponse($exception, $request);
        }
    }

    function searchShops(Request $request) {
        try {
            $language = $this->getLanguageHeader($request);
            $searchQuery = $request->query(GeneralApiKeys::$SEARCH_QUERY_KEY);
            $service = new ShopsService();
            $users = $service->searchShops($searchQuery, $language);
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

    function getShopItemsByShopId(Request $request, $id) {
        try {
            $service = new ShopItemService();
            $currentUserId = $service->getItemsByShopId($id);
            return ShopResponse::getSuccessResponse(ShopResponse::$DATA_CREATED_SUCCESS_RESPONSE, "", true, $currentUserId, $request);
        } catch (\Exception $exception) {
            return ShopResponse::getErrorResponse($exception, $request);
        }
    }

    function getMenuItemsInformation(Request $request, $id) {
        try {
            $service = new ShopsService();
            $currentUserId = $service->getShopMenuItems($id);
            return ShopResponse::getSuccessResponse(ShopResponse::$DATA_CREATED_SUCCESS_RESPONSE, "", true, $currentUserId, $request);
        } catch (\Exception $exception) {
            return ShopResponse::getErrorResponse($exception, $request);
        }
    }

    function createShopMenu(Request $request) {
        try {
            $service = new ShopsService();
            $currentUserId = $service->createShopMenu($request);
            return ShopResponse::getSuccessResponse(ShopResponse::$DATA_CREATED_SUCCESS_RESPONSE, "", true, $currentUserId, $request);
        } catch (\Exception $exception) {
            return ShopResponse::getErrorResponse($exception, $request);
        }
    }

    function getLastInsertedShops(Request $request) {
        try {
            $service = new ShopsService();
            $currentUserId = $service->getLastInsertedShops();
            if ($currentUserId != null) {
                return ShopResponse::getListResponse(ShopResponse::$SUCCESS_RESPONSE, "", true, $currentUserId, $request);
            } else {
                return ShopResponse::getNotFoundResponse(ShopResponse::$SUCCESS_RESPONSE, $request);
            }
        } catch (\Exception $exception) {
            return ShopResponse::getErrorResponse($exception, $request);
        }
    }

    function getAllMenusByShopId(Request $request, $id) {
        try {
            $service = new ShopsService();
            $currentUserId = $service->getAllMenusByShopId($id);
            return ShopResponse::getSuccessResponse(ShopResponse::$DATA_CREATED_SUCCESS_RESPONSE, "", true, $currentUserId, $request);
        } catch (\Exception $exception) {
            return ShopResponse::getErrorResponse($exception, $request);
        }
    }

    function deleteMenuByShopId(Request $request, $id) {
        try {
            $service = new ShopsService();
            $service->deleteMenuByShopId($id);
            return ShopResponse::getSuccessResponse(ShopResponse::$DATA_CREATED_SUCCESS_RESPONSE, "Data Successfully Deleted", true, null, $request);
        } catch (\Exception $exception) {
            return ShopResponse::getErrorResponse($exception, $request);
        }
    }

    function getAll(Request $request, Response $response)
    {
        try {
            $language = $this->getLanguageHeader($request);
            $service = new ShopsService();
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
            $user = new ShopsService();
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
            $userService = new ShopsService();
            $userService->deleteById($request);
            return ShopResponse::getSuccessResponse(ShopResponse::$SUCCESS_RESPONSE, "Data Deleted Successfully", true, null, $request);
        } catch (\Exception $exception) {
            echo $exception->getMessage();
            return ShopResponse::getErrorResponse($exception, $request);
        }
    }

    function deleteAll(Request $request, Response $response)
    {
        $userService = new ShopsService();
        $userService->deleteAll($request);
        return ShopResponse::getSuccessResponse(ShopResponse::$SUCCESS_RESPONSE, "Data Deleted Successfully", true, [], $request);
    }

    function getAllEnabledEntities(Request $request, Response $response)
    {
        try {
            $userService = new ShopsService();
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
            $userService = new ShopsService();
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
