<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use LadLib\Laravel\Database\TraitModelExtra;

class HrTimeSheet extends ModelGlxBase
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
        'time_in' => 'double',
        'time_out' => 'double',
        'over_time' => 'string',
        'date_type' => 'int',
        'n_session' => 'string',
        'meal' => 'string',
        'n_hour' => 'string',
        'task_id' => 'int',
        'org_id' => 'int',
        'n_late' => 'string',
        'time_frame' => 'string',
    ];
}
