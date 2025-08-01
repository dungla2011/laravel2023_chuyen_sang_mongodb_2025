<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use LadLib\Laravel\Database\TraitModelExtra;

class OrderShip extends ModelGlxBase
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
        'fee' => 'int',
        'created_at' => 'date',
        'updated_at' => 'date',
        'deleted_at' => 'date',
        'user_id' => 'int',
        'vendor_id' => 'int',
        'order_id' => 'int',
        'remote_tracking_id' => 'string',
        'status' => 'int',
        'log' => 'string',
        'pick_time' => 'date',
        'delive_time' => 'date',
        'remote_label' => 'string',
        'json_send' => 'string',
        'json_get' => 'string',
    ];
}
