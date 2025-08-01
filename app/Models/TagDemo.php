<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class TagDemo extends ModelGlxBase
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
        'name' => 'string',
        'created_at' => 'date',
        'updated_at' => 'date',
        'site_id' => 'int',
    ];
}
