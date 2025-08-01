<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use LadLib\Laravel\Database\TraitModelExtra;

class RoleUser extends ModelGlxBase
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
        'user_id' => 'int',
        'role_id' => 'int',
        'created_at' => 'date',
        'updated_at' => 'date',
        'site_id' => 'int',
        'deleted_at' => 'date',
    ];

    protected $table = 'role_user';
}
