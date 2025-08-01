<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductTag extends ModelGlxBase
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Define MongoDB field types for ProductTag model
     * Based on SQL table structure
     */
    protected static $mongoFieldTypes = [
        '_id' => 'objectId',
        'id' => 'int',
        'product_id' => 'int',
        'tag_id' => 'int',
        'created_at' => 'date',
        'updated_at' => 'date',
        'site_id' => 'int',
    ];
}
