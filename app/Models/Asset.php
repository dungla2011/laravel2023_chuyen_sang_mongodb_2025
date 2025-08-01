<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use LadLib\Laravel\Database\TraitModelExtra;

class Asset extends ModelGlxBase
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
        'id__' => 'string',
        'name' => 'string',
        'user_id' => 'int',
        'status' => 'int',
        'created_at' => 'date',
        'updated_at' => 'date',
        'deleted_at' => 'date',
        'image_list' => 'string',
        'log' => 'string',
        'barcode' => 'string',
        'description' => 'string',
        'parent_id' => 'int',
        'location_id' => 'int',
        'purchase_date' => 'date',
        'value' => 'double',
        'orders' => 'int',
    ];

    protected $connection = 'mysql_for_dev';

}
