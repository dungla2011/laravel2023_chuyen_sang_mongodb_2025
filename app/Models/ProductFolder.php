<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use LadLib\Laravel\Database\TraitModelExtra;

class ProductFolder extends ModelGlxBase
{
    use HasFactory, SoftDeletes, TraitModelExtra;

    protected $guarded = [];

    /**
     * Define MongoDB field types for ProductFolder model
     * Based on SQL table structure
     */
    protected static $mongoFieldTypes = [
        '_id' => 'objectId',
        'id' => 'int',
        'name' => 'string',
        'user_id' => 'int',
        'status' => 'int',
        'created_at' => 'date',
        'updated_at' => 'date',
        'deleted_at' => 'date',
        'image_list' => 'string',
        'log' => 'string',
        'parent_id' => 'int',
        'summary' => 'string',
        'content' => 'string',
        'orders' => 'int',
        'meta_desc' => 'string',
        'front' => 'int',
    ];

    public function getLinkPublic()
    {
        //        cstring2::toSlug();
        return '/san-pham/danh-muc/'.Str::slug($this->name).'.'.$this->id.'.html';
    }

    public function getMetaDesc()
    {
        return strip_tags($this->meta_desc ?? $this->name);
    }
}
