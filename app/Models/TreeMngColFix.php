<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use LadLib\Laravel\Database\TraitModelExtra;

class TreeMngColFix extends ModelGlxBase
{
    use HasFactory, TraitModelExtra;

    protected $guarded = [];

    /**
     * Define MongoDB field types
     * Auto-generated from SQL structure
     */
    protected static $mongoFieldTypes = [
        '_id' => 'objectId',
        'id' => 'int',
        'pid' => 'int',
        'node_id' => 'int',
        'col_fix' => 'int',
        'created_at' => 'date',
        'updated_at' => 'date',
        'log' => 'string',
    ];
}
