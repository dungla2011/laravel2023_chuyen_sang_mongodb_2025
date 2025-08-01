<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class DemoSub1 extends ModelGlxBase
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
        'demo_id' => 'int',
        'created_at' => 'date',
        'updated_at' => 'date',
        'sub_val' => 'string',
    ];
}
