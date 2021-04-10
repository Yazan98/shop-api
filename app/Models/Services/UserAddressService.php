<?php


namespace App\Models\Services;


use App\Exceptions\BadInformationException;
use App\Models\GeneralApiKeys;
use App\Models\Services\Validations\ShopStringValidation;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class UserAddressService implements ShopBaseServiceImplementation
{

    /**
     * @param Request $request
     * @throws BadInformationException
     */
    function saveEntity(Request $request)
    {
        // Get Attributes from Json Object
        $name = $request->input(UserAddress::$NAME);
        $userId = $request->input(UserAddress::$USER_ID);
        $locationLat = $request->input(UserAddress::$LOCATION_LAT);
        $locationLng = $request->input(UserAddress::$LOCATION_LNG);
        $phoneNumber = $request->input(UserAddress::$PHONE_NUMBER);

        // Validation
        ShopStringValidation::validateEmptyString($name, "Name Required");
        ShopStringValidation::validateEmptyString($locationLat, "Location Lat Required");
        ShopStringValidation::validateEmptyString($userId, "User Id Required");
        ShopStringValidation::validateEmptyString($locationLng, "Location Lng Required");
        ShopStringValidation::validateEmptyString($phoneNumber, "Phone Number Required");

        return DB::table(UserAddress::$TABLE_NAME)->insertGetId(array(
            UserAddress::$NAME => $name,
            UserAddress::$LOCATION_LAT => $locationLat,
            UserAddress::$LOCATION_LNG => $locationLng,
            UserAddress::$PHONE_NUMBER => $phoneNumber,
            UserAddress::$USER_ID => $userId,
            UserAddress::$IS_ENABLED => true,
            UserAddress::$CREATED_AT => Carbon::now(),
        ));
    }

    function getAll(Request $request, $language)
    {
        return DB::table(UserAddress::$TABLE_NAME)
            ->select(UserAddress::getVisibleAttributes($language))
            ->get();
    }

    /**
     * @param Request $request
     * @throws BadInformationException
     */
    function deleteById(Request $request)
    {
        $userId = $request->input(GeneralApiKeys::$USER_ID);
        ShopStringValidation::validateEmptyString($userId, "Branch Id Required Can't Be Null");
        $user = $this->getEntityById($userId);
        if ($user == null) {
            throw new BadInformationException("Branch Not Found By Id");
        }

        DB::table(UserAddress::$TABLE_NAME)
            ->where(UserAddress::$ID, $userId)
            ->delete();
    }

    function deleteAll(Request $request)
    {
        DB::table(UserAddress::$TABLE_NAME)->truncate();
    }

    function getAllEnabledEntities(Request $request)
    {
        return DB::table(UserAddress::$TABLE_NAME)
            ->where(UserAddress::$IS_ENABLED, true)
            ->select(UserAddress::getVisibleAttributes("en"))
            ->get();
    }

    function getAllDisabledEntities(Request $request)
    {
        return DB::table(UserAddress::$TABLE_NAME)
            ->where(UserAddress::$IS_ENABLED, false)
            ->select(UserAddress::getVisibleAttributes("en"))
            ->get();
    }

    function getEntityById($id)
    {
        return DB::table(UserAddress::$TABLE_NAME)
            ->select(UserAddress::getVisibleAttributes("en"))
            ->where(UserAddress::$ID, $id)
            ->lockForUpdate()
            ->get();
    }

}
