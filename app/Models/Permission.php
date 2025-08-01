<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permission extends ModelGlxBase
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Define MongoDB field types for Permission model
     * Based on SQL: CREATE TABLE `permissions` (...)
     */
    protected static $mongoFieldTypes = [
        '_id' => 'objectId',
        'id' => 'int',
        'route_name_code' => 'string',
        'display_name' => 'string',
        'created_at' => 'date',
        'updated_at' => 'date',
        'parent_id' => 'int',
        'prefix' => 'string',
        'url' => 'string',
        'site_id' => 'int',
    ];

    public function permissionChilds()
    {
        return $this->hasMany(Permission::class, 'parent_id');
    }

    //    function setPrimaryKey($key)
    //    {
    //        $this->primaryKey = $key;
    //    }
}
