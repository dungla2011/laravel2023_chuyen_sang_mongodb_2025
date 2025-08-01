<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use LadLib\Laravel\Database\TraitModelExtra;

class News extends ModelGlxBase
{
    use HasFactory, SoftDeletes, TraitModelExtra;

    protected $guarded = [];
    
    /**
     * Define MongoDB field types for News model
     * Based on SQL structure: CREATE TABLE `news` (...)
     */
    protected static $mongoFieldTypes = [
        '_id' => 'objectId',
        'id' => 'int',
        'name' => 'string',
        'user_id' => 'int',
        'created_at' => 'date',
        'deleted_at' => 'date',
        'updated_at' => 'date',
        'log' => 'string',
        'parent_id' => 'int',
        'summary' => 'string',
        'content' => 'string',
        'image_list' => 'string',
        'status' => 'int',
        'meta_desc' => 'string',
        'options' => 'int',
        'orders' => 'int',
        'publish_status' => 'int',
        'count_view' => 'int',
        // Common fields that might be added
        'site_id' => 'int',
        'slug' => 'string',
        'featured_image' => 'string',
        'tags' => 'array',
        'category_id' => 'int',
    ];

    public function getValidateRuleInsert()
    {

        //        if(!isIPDebug())
        //            return;
        //OK: '/^([^`\$<>]+)$/u'; //Chuỗi bất kỳ không chứa `$<>
        $sreg = '/^([^`\$<>]+)$/u';

        return [
            'name' => 'required|regex:'.$sreg.'|max:256',
            'summary' => 'nullable|regex:'.$sreg.'|max:2000',
        ];
    }

    public function getValidateRuleUpdate($id = null)
    {
        return $this->getValidateRuleInsert();
    }

    public function getLinkPublic()
    {
        return '/tin-tuc/'.Str::slug($this->name).".$this->id.html";
    }

    public function getMetaDesc()
    {
        return strip_tags($this->meta_desc ?? $this->name);
    }
}
