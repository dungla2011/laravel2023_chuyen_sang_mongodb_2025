<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use LadLib\Laravel\Database\TraitModelExtra;

class TaskInfo extends ModelGlxBase
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
        'name' => 'string',
        'description' => 'string',
        'status' => 'string',
        'priority' => 'string',
        'due_date' => 'date',
        'created_at' => 'date',
        'updated_at' => 'date',
        'deleted_at' => 'date',
        'assigned_to' => 'int',
        'parent_id' => 'int',
        'orders' => 'int',
        'file_list' => 'string',
        'parent_extra' => 'string',
        'parent_all' => 'string',
    ];

}
