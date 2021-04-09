<?php


namespace App\Models\Services;


use App\Exceptions\BadInformationException;
use App\Models\Category;
use App\Models\GeneralApiKeys;
use App\Models\Services\Validations\ShopStringValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

include('ShopBaseServiceImplementation.php');

class CategoryService implements ShopBaseServiceImplementation
{

    /**
     * @param Request $request
     * @throws BadInformationException
     */
    function saveEntity(Request $request)
    {
        // Get Attributes from Json Object
        $nameAr = $request->input(Category::$NAME_AR);
        $nameEn = $request->input(Category::$NAME_EN);
        $image = $request->input(Category::$IMAGE);

        // Validation
        ShopStringValidation::validateEmptyString($nameAr, "Arabic Name Required");
        ShopStringValidation::validateEmptyString($nameEn, "English Name Required");
        ShopStringValidation::validateEmptyString($image, "Category Logo Required");

        return DB::table(Category::$TABLE_NAME)->insertGetId(array(
            Category::$NAME_AR => $nameAr,
            Category::$NAME_EN => $nameEn,
            Category::$IMAGE => $image,
            Category::$IS_ENABLED => true,
            Category::$CREATED_AT => Carbon::now(),
        ));
    }

    function getAll(Request $request)
    {
        return DB::table(Category::$TABLE_NAME)
            ->select(Category::getSupportedEnglishValuesByQuery())
            ->get();
    }

    /**
     * @param Request $request
     * @throws BadInformationException
     */
    function deleteById(Request $request)
    {
        $userId = $request->input(GeneralApiKeys::$USER_ID);
        ShopStringValidation::validateEmptyString($userId, "Category Id Required Can't Be Null");
        $user = $this->getEntityById($userId);
        if ($user == null) {
            throw new BadInformationException("Category Not Found By Id");
        }

        DB::table(Category::$TABLE_NAME)
            ->where(Category::$ID, $userId)
            ->delete();
    }

    function deleteAll(Request $request)
    {
        DB::table(Category::$TABLE_NAME)->truncate();
    }

    function getAllEnabledEntities(Request $request)
    {
        return DB::table(Category::$TABLE_NAME)
            ->where(Category::$IS_ENABLED, true)
            ->select(Category::getSupportedEnglishValuesByQuery())
            ->get();
    }

    function getAllDisabledEntities(Request $request)
    {
        return DB::table(Category::$TABLE_NAME)
            ->where(Category::$IS_ENABLED, false)
            ->select(Category::getSupportedEnglishValuesByQuery())
            ->get();
    }

    function getEntityById($id)
    {
        return DB::table(Category::$TABLE_NAME)
            ->select(Category::getSupportedEnglishValuesByQuery())
            ->where('id', $id)
            ->lockForUpdate()
            ->get();
    }
}
