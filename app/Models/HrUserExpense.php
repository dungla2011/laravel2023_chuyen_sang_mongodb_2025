<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use LadLib\Laravel\Database\TraitModelExtra;

class HrUserExpense extends ModelGlxBase
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
        'time_frame' => 'string',
        'cat1' => 'int',
        'cat2' => 'int',
        'num1' => 'double',
        'num2' => 'double',
        'num3' => 'double',
        'num4' => 'double',
        'num_1' => 'double',
        'num_2' => 'double',
        'num_3' => 'double',
        'num_4' => 'double',
        'num5' => 'double',
        'num6' => 'double',
        'num_5' => 'double',
        'num_6' => 'double',
    ];

}
