<?php


namespace App\Models\Services;

use App\Exceptions\BadInformationException;
use App\Models\CommentResponse;
use App\Models\GeneralApiKeys;
use App\Models\ItemComment;
use App\Models\Services\Validations\ShopStringValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;


class ItemCommentService implements ShopBaseServiceImplementation
{

    /**
     * @param Request $request
     * @throws BadInformationException
     */
    function saveEntity(Request $request)
    {
        // Get Attributes from Json Object
        $userId = $request->input(ItemComment::$OWNER_ID);
        $content = $request->input(ItemComment::$CONTENT);
        $type = $request->input(ItemComment::$TYPE);
        $itemId = $request->input(ItemComment::$ITEM_ID);

        // Validation
        ShopStringValidation::validateEmptyString($userId, "User Id Required");
        ShopStringValidation::validateEmptyString($content, "Content Required");
        ShopStringValidation::validateEmptyString($type, "Type Required");
        ShopStringValidation::validateEmptyString($itemId, "Item Id Required");

        return DB::table(ItemComment::$TABLE_NAME)->insertGetId(array(
            ItemComment::$OWNER_ID => $userId,
            ItemComment::$CONTENT => $content,
            ItemComment::$TYPE => $type,
            ItemComment::$ITEM_ID => $itemId,
            ItemComment::$CREATED_AT => Carbon::now(),
        ));
    }

    /**
     * @param $itemId
     * @throws BadInformationException
     */
    function getCommentsByItemId($itemId) {
        ShopStringValidation::validateEmptyString($itemId, "Item Id Required");
        $shopInfo = self::getEntityById($itemId);
        if ($shopInfo == null) {
            throw new BadInformationException("Invalid Item Id");
        }

        $connectedMenuItemsResult = array();
        $itemCommentsQuery = self::getCommentsQueryByItemId($itemId);
        $comments = $itemCommentsQuery->get()->toArray();
        $ownerIds = $itemCommentsQuery->pluck(ItemComment::$ID)->toArray();
        if ($comments == null) {
            return array();
        }

        $userService = new UserService();
        foreach ($comments as $key => $value) {
            $itemResponse = new CommentResponse();
            $itemResponse->setComment($value);
            $itemResponse->setOwner($userService->getEntityById($ownerIds[$key]));
            $connectedMenuItemsResult[] = $itemResponse;
        }

        return $connectedMenuItemsResult;
    }

    private function getCommentsQueryByItemId($itemId) {
        return DB::table(ItemComment::$TABLE_NAME)
            ->where(ItemComment::$ITEM_ID, $itemId);
    }

    function getAll(Request $request, $language)
    {
        return DB::table(ItemComment::$TABLE_NAME)->get();
    }

    /**
     * @param Request $request
     * @throws BadInformationException
     */
    function deleteById(Request $request)
    {
        $userId = $request->input(GeneralApiKeys::$USER_ID);
        ShopStringValidation::validateEmptyString($userId, "Comment Id Required Can't Be Null");
        $user = $this->getEntityById($userId);
        if ($user == null) {
            throw new BadInformationException("Comment Not Found By Id");
        }

        DB::table(ItemComment::$TABLE_NAME)
            ->where(ItemComment::$ID, $userId)
            ->delete();
    }

    function deleteAll(Request $request)
    {
        DB::table(ItemComment::$TABLE_NAME)->truncate();
    }

    function getAllEnabledEntities(Request $request)
    {
        return self::getAll($request, "en");
    }

    function getAllDisabledEntities(Request $request)
    {
        return self::getAll($request, "en");
    }

    function getEntityById($id)
    {
        return DB::table(ItemComment::$TABLE_NAME)
            ->where(ItemComment::$ID, $id)
            ->lockForUpdate()
            ->get();
    }

}
