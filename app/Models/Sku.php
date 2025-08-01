<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use LadLib\Laravel\Database\TraitModelExtra;

class Sku extends ModelGlxBase
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
        'product_id' => 'int',
        'sku' => 'string',
        'price0' => 'int',
        'price' => 'int',
        'weight' => 'int',
        'deleted_at' => 'date',
        'created_at' => 'date',
        'updated_at' => 'date',
        'quantity' => 'int',
        'product_opt_list' => 'string',
        'width' => 'int',
        'height' => 'int',
        'param1' => 'int',
    ];
}
