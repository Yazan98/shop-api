<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class ItemComment
{
    use HasFactory, Notifiable;
    public static $TABLE_NAME = "items_comments";

    public static $CONTENT = "content";
    public static $ID = "id";
    public static $TYPE = "type";
    public static $OWNER_ID = "owner_id";
    public static $ITEM_ID = "item_id";
    public static $CREATED_AT = "created_at";

}
