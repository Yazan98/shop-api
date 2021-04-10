<?php

namespace App\Http\Controllers;

use App\Models\AuthResponse;
use App\Models\GeneralApiKeys;
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
                $newInsertedUser = $userService->getEntityById($currentUserId)->first();
                return ShopResponse::getSuccessResponse(ShopResponse::$DATA_CREATED_SUCCESS_RESPONSE, "", true, $newInsertedUser, $request);
            }
        } catch (\Exception $exception) {
            return ShopResponse::getErrorResponse($exception, $request);
        }
    }

    function loginAccount(Request $request) {
        try {
            $userService = new UserService();
            $userEmail = $request->input(GeneralApiKeys::$EMAIL_KEY);
            $userPassword = $request->input(GeneralApiKeys::$PASSWORD_KEY);
            $targetUser = $userService->loginAccount($userEmail, $userPassword);
            $tokenCredentials = $request->only(GeneralApiKeys::$EMAIL_KEY, GeneralApiKeys::$PASSWORD_KEY);
            $token = auth(GeneralApiKeys::$TOKEN_GUARD)->attempt($tokenCredentials);
            return ShopResponse::getSuccessResponse(ShopResponse::$SUCCESS_RESPONSE, "", true, new AuthResponse($targetUser, $token, "Bearer"), $request);
        } catch (\Exception $exception) {
            return ShopResponse::getErrorResponse($exception, $request);
        }
    }

    function getSecurityQuestionByEmailAddress(Request $request) {
        try {
            $userService = new UserService();
            $userEmail = $request->input(GeneralApiKeys::$EMAIL_KEY);
            $targetUser = $userService->getSecurityQuestionByEmailAddress($userEmail);
            return ShopResponse::getSuccessResponse(ShopResponse::$SUCCESS_RESPONSE, "", true, $targetUser, $request);
        } catch (\Exception $exception) {
            return ShopResponse::getErrorResponse($exception, $request);
        }
    }

    // Return Token Here to Use it When Reset the Password
    function verifyBySecurityQuestion(Request $request) {
        try {
            $userService = new UserService();
            $userEmail = $request->input(GeneralApiKeys::$EMAIL_KEY);
            $answer = $request->input(GeneralApiKeys::$SECURITY_ANSWER);
            $targetUser = $userService->verifyBySecurityQuestion($userEmail, $answer);
            return ShopResponse::getSuccessResponse(ShopResponse::$SUCCESS_RESPONSE, "", true, $targetUser, $request);
        } catch (\Exception $exception) {
            return ShopResponse::getErrorResponse($exception, $request);
        }
    }

    function getAll(Request $request, Response $response)
    {
        try {
            $language = self::getLanguageHeader($request);
            $service = new UserService();
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
            $user = new UserService();
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

    function verifyOtpCode(Request $request) {
        try {
            $userId = $request->input(GeneralApiKeys::$USER_ID);
            $verificationCode = $request->input(GeneralApiKeys::$VERIFICATION_CODE);
            $service = new UserService();
            $currentUser = $service->verifyOtpCode($userId, $verificationCode);
            return ShopResponse::getSuccessResponse(ShopResponse::$SUCCESS_RESPONSE, "", true, $currentUser, $request);
        } catch (\Exception $exception) {
            echo $exception->getMessage();
            return ShopResponse::getErrorResponse($exception, $request);
        }
    }

    function refreshOtp(Request $request) {
        try {
            $user = new UserService();
            $currentUser = $user->refreshOtpCode($request);
            return ShopResponse::getSuccessResponse(ShopResponse::$SUCCESS_RESPONSE, "Code Sent", true, $currentUser, $request);
        } catch (\Exception $exception) {
            echo $exception->getMessage();
            return ShopResponse::getErrorResponse($exception, $request);
        }
    }

    function deleteById(Request $request, Response $response)
    {
        try {
            $userService = new UserService();
            $userService->deleteById($request);
            return ShopResponse::getSuccessResponse(ShopResponse::$SUCCESS_RESPONSE, "Data Deleted Successfully", true, null, $request);
        } catch (\Exception $exception) {
            echo $exception->getMessage();
            return ShopResponse::getErrorResponse($exception, $request);
        }
    }

    function deleteAll(Request $request, Response $response)
    {
        $userService = new UserService();
        $userService->deleteAll($request);
        return ShopResponse::getSuccessResponse(ShopResponse::$SUCCESS_RESPONSE, "Data Deleted Successfully", true, [], $request);
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
