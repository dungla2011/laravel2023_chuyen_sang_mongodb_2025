<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends ModelGlxBase
{
    use HasFactory;
    use SoftDeletes;

    //    private $name;
    //    private $parent_id;
    protected $fillable = ['name', 'parent_id'];
    
    /**
     * Define MongoDB field types for Category model
     * Based on SQL: CREATE TABLE `categories` (...)
     */
    protected static $mongoFieldTypes = [
        '_id' => 'objectId',
        'id' => 'int',
        'name' => 'string',
        'parent_id' => 'int',
        'slug' => 'string',
        'created_at' => 'date',
        'updated_at' => 'date',
        'deleted_at' => 'date',
        'site_id' => 'int',
        // Additional common fields
        'description' => 'string',
        'image' => 'string',
        'status' => 'int',
        'order' => 'int',
        'meta_title' => 'string',
        'meta_description' => 'string',
    ];
}
