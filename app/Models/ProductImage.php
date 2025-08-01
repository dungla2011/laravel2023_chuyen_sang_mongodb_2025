<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductImage extends ModelGlxBase
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Define MongoDB field types
     * Auto-generated from SQL structure
     */
    protected static $mongoFieldTypes = [
        '_id' => 'objectId',
        'id' => 'int',
        'image_path' => 'string',
        'product_id' => 'int',
        'created_at' => 'date',
        'updated_at' => 'date',
        'image_name' => 'string',
        'site_id' => 'int',
    ];
}
