<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use LadLib\Laravel\Database\TraitModelExtra;

class ProductVariantOption extends ModelGlxBase
{
    use HasFactory, TraitModelExtra, SoftDeletes;

    protected $guarded = [];

    /**
     * Define MongoDB field types
     * Auto-generated from SQL structure
     */
    protected static $mongoFieldTypes = [
        '_id' => 'objectId',
        'id' => 'int',
        'product_variant_id' => 'int',
        'name' => 'string',
        'deleted_at' => 'date',
        'created_at' => 'date',
        'updated_at' => 'date',
    ];
}
