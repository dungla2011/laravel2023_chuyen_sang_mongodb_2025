<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use LadLib\Laravel\Database\TraitModelExtra;

class NewsFolder extends ModelGlxBase
{
    use HasFactory, SoftDeletes, TraitModelExtra;

    protected $guarded = [];

    /**
     * Define MongoDB field types for NewsFolder model
     * Based on SQL table structure
     */
    protected static $mongoFieldTypes = [
        '_id' => 'objectId',
        'id' => 'int',
        'name' => 'string',
        'user_id' => 'int',
        'created_at' => 'date',
        'deleted_at' => 'date',
        'updated_at' => 'date',
        'parent_id' => 'int',
        'log' => 'string',
        'status' => 'int',
        'orders' => 'int',
        'front' => 'int',
    ];

    public function getLinkPublic()
    {
        return '/tin-tuc/s/'.Str::slug($this->name).".$this->id.html";
    }

    public function getMetaDesc()
    {
        return strip_tags($this->meta_desc ?? $this->name);
    }
}
