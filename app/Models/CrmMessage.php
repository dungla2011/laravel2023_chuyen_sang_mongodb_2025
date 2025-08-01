<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use LadLib\Laravel\Database\TraitModelExtra;

class CrmMessage extends ModelGlxBase
{
    use HasFactory, SoftDeletes, TraitModelExtra;
    protected $guarded = [];

    /**
     * Define MongoDB field types for CrmMessage model
     * Based on SQL table structure
     */
    protected static $mongoFieldTypes = [
        '_id' => 'objectId',
        'id' => 'int',
        'name' => 'string',
        'user_id' => 'int',
        'status' => 'int',
        'type' => 'int',
        'created_at' => 'date',
        'updated_at' => 'date',
        'deleted_at' => 'date',
        'image_list' => 'string',
        'log' => 'string',
        'msg_id' => 'string',
        'cli_msg_id' => 'string',
        'action_id' => 'string',
        'msg_type' => 'string',
        'uid_from' => 'string',
        'id_to' => 'string',
        'd_name' => 'string',
        'ts' => 'int',
        'content' => 'string',
        'notify' => 'int',
        'ttl' => 'int',
        'uin' => 'string',
        'user_id_ext' => 'string',
        'cmd' => 'int',
        'st' => 'int',
        'at' => 'int',
        'real_msg_id' => 'string',
        'thread_id' => 'string',
        'is_self' => 'int',
        'property_ext' => 'string',
        'params_ext' => 'string',
        'channel_name' => 'string',
    ];

}
