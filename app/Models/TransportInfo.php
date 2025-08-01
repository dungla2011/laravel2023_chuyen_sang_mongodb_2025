<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use LadLib\Laravel\Database\TraitModelExtra;

class TransportInfo extends ModelGlxBase
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
        'from_address' => 'string',
        'to_address' => 'string',
        'created_at' => 'date',
        'updated_at' => 'date',
        'deleted_at' => 'date',
        'user_id' => 'int',
        'phone_request' => 'string',
        'email_request' => 'string',
        'text_desc' => 'string',
        'user_id_post' => 'int',
        'user_id_get' => 'int',
        'service_require' => 'int',
        'start_time' => 'date',
        'end_time' => 'date',
        'money' => 'int',
        'done_at' => 'date',
        'status' => 'int',
        'image_list' => 'string',
    ];
}
