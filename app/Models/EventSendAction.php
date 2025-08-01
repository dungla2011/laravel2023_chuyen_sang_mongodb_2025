<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use LadLib\Laravel\Database\TraitModelExtra;

class EventSendAction extends ModelGlxBase
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
        'status' => 'int',
        'created_at' => 'date',
        'updated_at' => 'date',
        'deleted_at' => 'date',
        'image_list' => 'string',
        'log' => 'string',
        'type' => 'string',
        'event_id' => 'int',
        'done' => 'int',
        'count_send' => 'int',
        'pusher_chanel' => 'string',
        'select_content' => 'string',
        'select_user_type' => 'string',
        'user_email_send_override' => 'string',
        'last_force_send' => 'date',
        'content_raw_send' => 'string',
        'list_uid_send_done' => 'string',
        'count_success' => 'string',
        'pushed_all_sms_to_queue' => 'date',
    ];
}
