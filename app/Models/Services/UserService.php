<?php

namespace App\Models\Services;

use App\Exceptions\BadInformationException;
use App\Models\GeneralApiKeys;
use App\Models\PhoneNumber;
use App\Models\Services\Validations\ShopStringValidation;
use App\Models\User;
use App\Models\UserCreationSender;
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

            // Database Validation
            if (self::isPhoneNumberAlreadyExists($phoneNumber)) {
                throw new BadInformationException( "Phone Number Already Used ...");
            } elseif (self::isEmailAlreadyExists($email)) {
                throw new BadInformationException( "Email Already Used ...");
            }

            // User Input Validation
            if (ShopStringValidation::isStringsEquals(User::$GENDER_SUPPORTED[0], $gender) || ShopStringValidation::isStringsEquals(User::$GENDER_SUPPORTED[1], $gender)) {
                // Gender Type Supported
            } else {
                throw new BadInformationException( "Gender Type is Not Supported Please Enter Supported Type");
            }

            // User Input Validation
            if (ShopStringValidation::isStringsEquals(User::$TYPE_SUPPORTED[0], $type) || ShopStringValidation::isStringsEquals(User::$TYPE_SUPPORTED[1], $type) || ShopStringValidation::isStringsEquals(User::$TYPE_SUPPORTED[2], $type)) {
                // Account Type Supported
            } else {
                throw new BadInformationException( "Account Type is Not Supported Please Enter Supported Type");
            }

            // Validation Successful Create User Now
            $newUserId = DB::table(User::$TABLE_NAME)->insertGetId(array(
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

            // Send SMS Message With Code
            self::createVerificationCodePhoneNumberForNewUser($phoneNumber, $newUserId, $name, $email);
            return $newUserId;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public function getProfileEmailQuery($email) {
        return DB::table(User::$TABLE_NAME)
            ->where(User::$EMAIL, $email);
    }

    /**
     * @param $id
     * @param $verificationCode
     * @throws BadInformationException
     */
    function verifyOtpCode($id, $verificationCode) {
        ShopStringValidation::validateEmptyString($id, "User Id Key : Required");
        ShopStringValidation::validateEmptyString($verificationCode, "Message Verification Code Required");
        $targetUser = $this->getEntityById($id);
        if ($targetUser == null) {
            throw new BadInformationException("User Not Found For this Id Please Send Correct Data");
        }

        $savedVerificationCode = self::getVerificationCodeByUserId($id);
        if (ShopStringValidation::isStringsEquals($savedVerificationCode, $verificationCode)) {
            self::updateAccountToVerifiedAccount($id);
            self::removeOldVerificationCodeByUserId($id);
            return $this->getEntityById($id)->first();
        } else {
            throw new BadInformationException("Verification Code Invalid Please Send Correct Code Or Request New One");
        }
    }

    private function removeOldVerificationCodeByUserId($id) {
        DB::table(PhoneNumber::$TABLE_NAME)
            ->where(PhoneNumber::$USER_ID, $id)
            ->delete();
    }

    private function updateAccountToVerifiedAccount($id) {
        DB::table(User::$TABLE_NAME)
            ->where(User::$ACCOUNT_ID, $id)
            ->update(array(
                User::$IS_ACCOUNT_ACTIVATED => true,
                User::$IS_ENABLED => true,
                User::$ACCOUNT_STATUS => "VERIFIED",
                User::$IS_ACCOUNT_ENABLED => true
            ));
    }

    function getVerificationCodeByUserId($userId) {
        return DB::table(PhoneNumber::$TABLE_NAME)
            ->select(PhoneNumber::$CODE)
            ->where(PhoneNumber::$USER_ID, $userId)
            ->value(PhoneNumber::$CODE);
    }

    function createVerificationCodePhoneNumberForNewUser($phoneNumber, $id, $userName, $email) {
        $verificationCode = self::getGeneratedVerificationCode();
        DB::table(PhoneNumber::$TABLE_NAME)->insert(array(
            PhoneNumber::$CODE => $verificationCode,
            PhoneNumber::$CREATED_AT => Carbon::now(),
            PhoneNumber::$USER_ID => $id
        ));

//        $userSender = new UserCreationSender($verificationCode, $phoneNumber, $email, $userName);
//        $userSender->start();
    }

    /**
     * @param Request $request
     * @throws BadInformationException
     */
    function refreshOtpCode(Request $request) {
        $id = $request->input(GeneralApiKeys::$USER_ID);
        $user = self::getEntityById($id);
        if ($user == null) {
            throw new BadInformationException("UserId Invalid");
        }

        DB::table(PhoneNumber::$TABLE_NAME)
            ->where(PhoneNumber::$USER_ID, $id)
            ->delete();

        $verificationCode = self::getGeneratedVerificationCode();
        DB::table(PhoneNumber::$TABLE_NAME)->insert(array(
            PhoneNumber::$CODE => $verificationCode,
            PhoneNumber::$CREATED_AT => Carbon::now(),
            PhoneNumber::$USER_ID => $id
        ));

//        $userSender = new UserCreationSender($verificationCode, $request->input(PhoneNumber::$PHONE_NUMBER), "", "");
//        $userSender->start();
    }

    private function getGeneratedVerificationCode() {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 6; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * @param $email
     * @param $password
     * @throws BadInformationException
     */
    function loginAccount($email, $password) {
        ShopStringValidation::validateEmptyString($email, "Email Required Can't Be Empty");
        ShopStringValidation::validateEmptyString($password, "Password Required Can't Be Empty");
        $userQuery = self::getAccountByUserEmail($email);
        $user = $userQuery->first();
        if ($user == null) {
            throw new BadInformationException("Incorrect Email Or Password Please Try Again");
        }

        $hashedPassword = $userQuery->value(User::$PASSWORD);
        $isAccountAllowed =  $userQuery->value(User::$IS_ENABLED) && $userQuery->value(User::$IS_ACCOUNT_ACTIVATED);
        $userId = $userQuery->value(User::$ACCOUNT_ID);
        ShopStringValidation::validateEmptyString($hashedPassword, "Hashed Password Can't By Empty");
        if (!$isAccountAllowed) {
            throw new BadInformationException("Account Not Verified, Please Verify The Phone Number");
        }

        if (Hash::check($password, $hashedPassword)) {
            return $this->getEntityById($userId)->first();
        } else {
            throw new BadInformationException("Incorrect Email Or Password Please Try Again");
        }
    }

    /**
     * @param $email
     * @throws BadInformationException
     */
    function getSecurityQuestionByEmailAddress($email) {
        ShopStringValidation::validateEmptyString($email, "Email Required Can't Be Empty");
        $userQuery = self::getAccountByUserEmail($email);
        $user = $userQuery->first();
        if ($user == null) {
            throw new BadInformationException("User Not Found By Email Please Try Again");
        }

        $securityQuestion = $userQuery->value(User::$SECURITY_QUESTION);
        ShopStringValidation::validateEmptyString($securityQuestion, "Security Question Null");
        return $securityQuestion;
    }

    /**
     * @param $email
     * @param $answer
     * @throws BadInformationException
     */
    function verifyBySecurityQuestion($email, $answer) {
        ShopStringValidation::validateEmptyString($email, "Email Required Can't Be Empty");
        ShopStringValidation::validateEmptyString($answer, "Security Answer Required Can't Be Empty");
        $userQuery = self::getAccountByUserEmail($email);
        $user = $userQuery->first();
        if ($user == null) {
            throw new BadInformationException("User Not Found By Email Please Try Again");
        }

        $securityAnswer = $userQuery->value(User::$SECURITY_QUESTION_ANSWER);
        return ShopStringValidation::isStringsEquals($securityAnswer, $answer);
    }

    function getAccountByUserEmail($email) {
        return DB::table(User::$TABLE_NAME)
            ->where(User::$EMAIL, $email);
    }

    function isPhoneNumberAlreadyExists($phoneNumber) {
        $userExists = DB::table(User::$TABLE_NAME)
            ->where(User::$PHONE_NUMBER, $phoneNumber)
            ->lockForUpdate()
            ->get();

        return $userExists != null && count($userExists) > 0;
    }

    function isEmailAlreadyExists($email) {
        $userExists = DB::table(User::$TABLE_NAME)
            ->where(User::$EMAIL, $email)
            ->lockForUpdate()
            ->get();

        return $userExists != null && count($userExists) > 0;
    }

    function getAll(Request $request, $language)
    {
        return DB::table(User::$TABLE_NAME)
            ->select(User::getVisibleResponseAttributes())
            ->get();
    }

    /**
     * @param Request $request
     * @throws BadInformationException
     */
    function deleteById(Request $request)
    {
        $userId = $request->input(GeneralApiKeys::$USER_ID);
        ShopStringValidation::validateEmptyString($userId, "User Id Required Can't Be Null");
        $user = $this->getEntityById($userId);
        if ($user == null) {
            throw new BadInformationException("User Not Found By Id");
        }

        DB::table(User::$TABLE_NAME)
            ->where(User::$ACCOUNT_ID, $userId)
            ->delete();
    }

    function deleteAll(Request $request)
    {
        DB::table(User::$TABLE_NAME)->truncate();
    }

    function getAllEnabledEntities(Request $request)
    {
        // TODO: Implement getAllEnabledEntities() method.
    }

    function getAllDisabledEntities(Request $request)
    {
        // TODO: Implement getAllDisabledEntities() method.
    }

    public function getEntityById($id)
    {
        return DB::table(User::$TABLE_NAME)
            ->select(User::getVisibleResponseAttributes())
            ->where('id', $id)
            ->lockForUpdate()
            ->get();
    }

}
