<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class DemoFolderTbl extends ModelGlxBase
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    /**
     * Define MongoDB field types
     * Auto-generated from SQL structure
     */
    protected static $mongoFieldTypes = [
        '_id' => 'objectId',
        'id' => 'int',
        'created_at' => 'date',
        'updated_at' => 'date',
        'deleted_at' => 'date',
        'name' => 'string',
        'user_id' => 'int',
        'parent_id' => 'string',
        'summary' => 'string',
        'status' => 'int',
        'log' => 'string',
        'orders' => 'int',
    ];
}
