<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use LadLib\Laravel\Database\TraitModelExtra;

class QuizClass extends ModelGlxBase
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
        'parent_id' => 'int',
        'orders' => 'int',
    ];
}
