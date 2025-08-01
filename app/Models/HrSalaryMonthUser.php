<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use LadLib\Laravel\Database\TraitModelExtra;

class HrSalaryMonthUser extends ModelGlxBase
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
        'user_id' => 'int',
        'status' => 'int',
        'created_at' => 'date',
        'updated_at' => 'date',
        'deleted_at' => 'date',
        'image_list' => 'string',
        'log' => 'string',
        'month' => 'string',
        'total' => 'int',
        'sparam1' => 'int',
        'sparam2' => 'int',
        'sparam3' => 'int',
        'sparam4' => 'int',
        'sparam5' => 'int',
        'sparam6' => 'int',
        'sparam7' => 'int',
        'sparam8' => 'int',
        'sparam9' => 'int',
        'sparam10' => 'int',
        'sparam11' => 'int',
        'sparam12' => 'int',
        'sparam13' => 'int',
        'sparam14' => 'int',
        'sparam15' => 'int',
        'sparam16' => 'int',
        'sparam17' => 'int',
        'sparam18' => 'int',
    ];
}
