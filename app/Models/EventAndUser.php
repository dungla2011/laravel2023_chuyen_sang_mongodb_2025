<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use LadLib\Laravel\Database\TraitModelExtra;

class EventAndUser extends ModelGlxBase
{
    use HasFactory, SoftDeletes, TraitModelExtra;

    protected $guarded = [];

    /**
     * Define MongoDB field types for EventAndUser model
     * Based on SQL table structure
     */
    protected static $mongoFieldTypes = [
        '_id' => 'objectId',
        'id' => 'int',
        'name' => 'string',
        'user_id' => 'int',
        'user_event_id' => 'int',
        'event_id' => 'int',
        'status' => 'int',
        'created_at' => 'date',
        'updated_at' => 'date',
        'deleted_at' => 'date',
        'image_list' => 'string',
        'log' => 'string',
        'sent_mail_at' => 'date',
        'sent_sms_at' => 'date',
        'confirm_join_at' => 'date',
        'deny_join_at' => 'date',
        'attend_at' => 'date',
        'note' => 'string',
        'extra_info1' => 'string',
        'extra_info2' => 'string',
        'extra_info3' => 'string',
        'extra_info4' => 'string',
        'extra_info5' => 'string',
        'signature' => 'int',
    ];

    //    public $user_event_id;

}
