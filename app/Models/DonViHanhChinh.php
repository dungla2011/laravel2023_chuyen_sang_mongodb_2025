<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use LadLib\Laravel\Database\TraitModelExtra;

class DonViHanhChinh extends ModelGlxBase
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
        'name' => 'string',
        'code' => 'string',
        'type' => 'string',
        'parent_id' => 'int',
        'level' => 'int',
        'created_at' => 'date',
        'updated_at' => 'date',
        'deleted_at' => 'date',
        'orders' => 'int',
    ];

    public function __construct(array $attributes = [])
    {
        $this->setConnection('mysql_for_common');
        parent::__construct($attributes);
    }
}
