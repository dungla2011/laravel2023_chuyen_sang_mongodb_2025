<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use LadLib\Laravel\Database\TraitModelExtra;

class PartnerInfo extends ModelGlxBase
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
        'created_at' => 'date',
        'updated_at' => 'date',
        'name' => 'string',
        'deleted_at' => 'date',
        'partner_name' => 'string',
        'token_api' => 'string',
        'note' => 'string',
    ];
}
