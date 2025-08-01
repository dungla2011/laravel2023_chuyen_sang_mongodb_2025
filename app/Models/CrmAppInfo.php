<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use LadLib\Laravel\Database\TraitModelExtra;

class CrmAppInfo extends ModelGlxBase
{
    use HasFactory, SoftDeletes, TraitModelExtra;
    protected $guarded = [];

    /**
     * Define MongoDB field types for CrmAppInfo model
     * Based on SQL table structure
     */
    protected static $mongoFieldTypes = [
        '_id' => 'objectId',
        'id' => 'int',
        'name' => 'string',
        'user_id' => 'int',
        'status' => 'int',
        'created_at' => 'date',
        'updated_at' => 'date',
        'deleted_at' => 'date',
        'image_list' => 'string',
        'log' => 'string',
    ];

    static function insertOrUpdateFBTokenAndReadyStatus($firebase_token, $ready)
    {
        if(!$firebase_token)
            return;
        $obj = self::where('firebase_token', $firebase_token)->first();
        if (!$obj) {
            $obj = new self();
            $obj->firebase_token = $firebase_token;
        }
        if($ready != -1)
            $obj->ready = $ready;

        $obj->save();
        return $obj;

    }

}
