<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use LadLib\Common\UrlHelper1;
use LadLib\Laravel\Database\TraitModelExtra;

class LogUser extends ModelGlxBase
{
    use HasFactory, SoftDeletes, TraitModelExtra;

    protected $guarded = [];

    /**
     * Define MongoDB field types
     * Auto-generated from SQL structure
     */
    protected static $mongoFieldTypes = [
        '_id' => 'objectId',
        'id' => 'int',
        'name' => 'string',
        'user_id' => 'int',
        'admin_uid' => 'int',
        'status' => 'int',
        'created_at' => 'date',
        'updated_at' => 'date',
        'deleted_at' => 'date',
        'image_list' => 'string',
        'log' => 'string',
        'action' => 'string',
        'url' => 'string',
        'ip' => 'string',
        'comment' => 'string',
    ];

    public static function FInsertLog($action = null, $url = '', $comment = '', $uid = null, $time = null, $ip = null)
    {
        if (! $url) {
            $url = UrlHelper1::getUrlRequestUri();
        }
        $obj = new LogUser();
        $obj->url = $url;
        if (! $ip) {
            $obj->ip = @$_SERVER['REMOTE_ADDR'];
        } else {
            $obj->ip = $ip;
        }

        $obj->user_id = getCurrentUserId();
        $obj->comment = $comment;

        if ($uidAdm = isSupperAdminDevCookie()) {
            $obj->admin_uid = $uidAdm;
        }

        $obj->save();
    }
}
