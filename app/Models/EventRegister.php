<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use LadLib\Laravel\Database\TraitModelExtra;

class EventRegister extends ModelGlxBase
{
    use HasFactory, SoftDeletes, TraitModelExtra;
    protected $guarded = [];

    /**
     * Define MongoDB field types for EventRegister model
     * Based on SQL table structure
     */
    protected static $mongoFieldTypes = [
        '_id' => 'objectId',
        'id' => 'int',
        'name' => 'string',
        'user_id' => 'int',
        'user_event_id' => 'int',
        'status' => 'int',
        'created_at' => 'date',
        'updated_at' => 'date',
        'deleted_at' => 'date',
        'image_list' => 'string',
        'log' => 'string',
        'event_id' => 'int',
        'phone' => 'string',
        'address' => 'string',
        'organization' => 'string',
        'note' => 'string',
        'email' => 'string',
        'first_name' => 'string',
        'last_name' => 'string',
        'reg_code' => 'string',
        'reg_confirm_time' => 'date',
        'lang' => 'string',
        'gender' => 'int',
        'designation' => 'string',
        'content_mail1' => 'string',
        'content_mail2' => 'string',
        'sub_event_list' => 'string',
    ];

}
