<?php

namespace App\Models\Services;

use App\Exceptions\BadInformationException;
use App\Models\Services\Validations\ShopStringValidation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

include('ShopBaseServiceImplementation.php');

class UserService implements ShopBaseServiceImplementation
{

    /**
     * @param Request $request
     * @return int
     * @throws BadInformationException
     */
    public function saveEntity(Request $request)
    {
        try {
            // Get Attributes from Json Object
            $name = $request->input(User::$USERNAME);
            $image = $request->input(User::$IMAGE);
            $password = $request->input(User::$PASSWORD);
            $email = $request->input(User::$EMAIL);
            $gender = $request->input(User::$GENDER);
            $age = $request->input(User::$AGE);
            $phoneNumber = $request->input(User::$PHONE_NUMBER);
            $latLocation = $request->input(User::$LOCATION_LAT);
            $lngLocation = $request->input(User::$LOCATION_LNG);
            $locationName = $request->input(User::$LOCATION_NAME);
            $securityQuestion = $request->input(User::$SECURITY_QUESTION);
            $securityQuestionAnswer = $request->input(User::$SECURITY_QUESTION_ANSWER);
            $type = $request->input(User::$TYPE);

            // Validation
            ShopStringValidation::validateEmptyString($name, "Username Required (Field name)");
            ShopStringValidation::validateEmptyString($image, "User Image Required (Field image)");
            ShopStringValidation::validateEmptyString($password, "User Password Required (Field password)");
            ShopStringValidation::validateEmptyString($email, "User Email Required (Field email)");
            ShopStringValidation::validateEmptyString($gender, "User Gender Required (Field gender)");
            ShopStringValidation::validateEmptyString($phoneNumber, "User phoneNumber Required (Field phone_number)");
            ShopStringValidation::validateEmptyString($locationName, "User locationName Required (Field location_name)");
            ShopStringValidation::validateEmptyString($securityQuestion, "Security Question Required Field (security_question)");
            ShopStringValidation::validateEmptyString($securityQuestionAnswer, "Security Question Answer Required Field (security_question_answer)");
            ShopStringValidation::validateEmail($email, "Invalid Email Please Write Good Email To Continue");
            ShopStringValidation::validateStringMinLength($password, "User Password Length Required Min 8 (Field password)", 8);
            ShopStringValidation::validateStringMaxLength($password, "User Password Length Required Max 25 (Field password)", 25);
            if (self::isPhoneNumberAlreadyExists($phoneNumber)) {
                throw new BadInformationException( "Phone Number Already Used ...");
            } elseif (self::isEmailAlreadyExists($email)) {
                throw new BadInformationException( "Email Already Used ...");
            }

            if (!ShopStringValidation::isStringsEquals(User::$GENDER_SUPPORTED[0], $gender) || !ShopStringValidation::isStringsEquals(User::$GENDER_SUPPORTED[1], $gender)) {
                throw new BadInformationException( "Gender Type is Not Supported Please Enter Supported Type");
            }

            if (!ShopStringValidation::isStringsEquals(User::$TYPE_SUPPORTED[0], $type) || !ShopStringValidation::isStringsEquals(User::$TYPE_SUPPORTED[1], $type) || !ShopStringValidation::isStringsEquals(User::$TYPE_SUPPORTED[2], $type)) {
                throw new BadInformationException( "Account Type is Not Supported Please Enter Supported Type");
            }

            // Validation Successful Create User Now
            return DB::table(User::$TABLE_NAME)->insertGetId(array(
                User::$USERNAME => $name,
                User::$IMAGE => $image,
                User::$PASSWORD => Hash::make($password),
                User::$EMAIL => $email,
                User::$GENDER => $gender,
                User::$AGE => $age,
                User::$PHONE_NUMBER => $phoneNumber,
                User::$LOCATION_LAT => $latLocation,
                User::$LOCATION_LNG => $lngLocation,
                User::$LOCATION_NAME => $locationName,
                User::$SECURITY_QUESTION => $securityQuestion,
                User::$SECURITY_QUESTION_ANSWER => $securityQuestionAnswer,
                User::$TYPE => $type,
                User::$CREATED_AT => Carbon::now(),
            ));
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    function isPhoneNumberAlreadyExists($phoneNumber) {
        $userExists = DB::table(User::$TABLE_NAME)
            ->where(User::$PHONE_NUMBER, $phoneNumber)
            ->lockForUpdate()
            ->get();

        return $userExists != null;
    }

    function isEmailAlreadyExists($email) {
        $userExists = DB::table(User::$TABLE_NAME)
            ->where(User::$EMAIL, $email)
            ->lockForUpdate()
            ->get();

        return $userExists != null;
    }

    function getAll(Request $request)
    {
        // TODO: Implement getAll() method.
    }

    function getById(Request $request, $id)
    {
        // TODO: Implement getById() method.
    }

    function deleteById(Request $request)
    {
        // TODO: Implement deleteById() method.
    }

    function deleteAll(Request $request)
    {
        // TODO: Implement deleteAll() method.
    }

    function getAllEnabledEntities(Request $request)
    {
        // TODO: Implement getAllEnabledEntities() method.
    }

    function getAllDisabledEntities(Request $request)
    {
        // TODO: Implement getAllDisabledEntities() method.
    }

    function getEntityById($id)
    {
        // TODO: Implement getEntityById() method.
    }
}
