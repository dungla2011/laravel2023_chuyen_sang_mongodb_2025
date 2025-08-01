<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use LadLib\Laravel\Database\TraitModelExtra;

class ConferenceInfo extends ModelGlxBase
{
    use HasFactory, SoftDeletes, TraitModelExtra;
    protected $guarded = [];

    /**
     * Define MongoDB field types for ConferenceInfo model
     * Based on SQL table structure
     */
    protected static $mongoFieldTypes = [
        '_id' => 'objectId',
        'id' => 'int',
        'name' => 'string',
        'sub_title' => 'string',
        'summary' => 'string',
        'images' => 'string',
        'cat' => 'int',
        'key_notes' => 'string',
        'user_id' => 'int',
        'status' => 'int',
        'created_at' => 'date',
        'updated_at' => 'date',
        'deleted_at' => 'date',
        'image_list' => 'string',
        'log' => 'string',
        'conf1_video' => 'string',
        'conf1_images' => 'string',
        'conf1_image_title' => 'string',
        'conf1_timesheet' => 'string',
        'conf1_keynote' => 'string',
        'conf1_name' => 'string',
        'conf2_name' => 'string',
        'conf2_keynote' => 'string',
        'conf2_timesheet' => 'string',
        'conf2_images' => 'string',
        'conf2_image_title' => 'string',
        'conf2_video' => 'string',
        'conf3_video' => 'string',
        'conf3_images' => 'string',
        'conf3_image_title' => 'string',
        'conf3_timesheet' => 'string',
        'conf3_keynote' => 'string',
        'conf3_name' => 'string',
        'video_bottom' => 'string',
        'supporters' => 'string',
        'right_column' => 'string',
        'orders' => 'int',
    ];

}
