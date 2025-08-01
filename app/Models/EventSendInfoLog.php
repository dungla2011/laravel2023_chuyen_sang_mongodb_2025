<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use LadLib\Laravel\Database\TraitModelExtra;

class EventSendInfoLog extends ModelGlxBase
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
        'event_user_id' => 'int',
        'event_id' => 'int',
        'type' => 'string',
        'status' => 'int',
        'created_at' => 'date',
        'updated_at' => 'date',
        'deleted_at' => 'date',
        'image_list' => 'string',
        'log' => 'string',
        'title_email' => 'string',
        'content' => 'string',
        'content_sms' => 'string',
        'session_id' => 'string',
        'sms_unique_session' => 'string',
        'comment' => 'string',
        'send_or_get' => 'string',
        'count_success' => 'int',
        'user_id' => 'int',
        'last_app_sms_request_to_send' => 'date',
        'done_at' => 'string',
        'phone_send' => 'string',
        'count_retry_send' => 'int',
    ];
}
