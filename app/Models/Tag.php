<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends ModelGlxBase
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Define MongoDB field types for Tag model
     * Based on SQL table structure
     */
    protected static $mongoFieldTypes = [
        '_id' => 'objectId',
        'id' => 'int',
        'name' => 'string',
        'created_at' => 'date',
        'updated_at' => 'date',
        'site_id' => 'int',
    ];
}
