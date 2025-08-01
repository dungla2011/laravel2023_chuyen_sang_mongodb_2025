<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use LadLib\Common\cstring2;
use LadLib\Laravel\Database\TraitModelExtra;



class Product extends ModelGlxBase
{
    use HasFactory, SoftDeletes, TraitModelExtra;

    protected $guarded = [];

    /**
     * Define MongoDB field types for Product model
     * Based on SQL: CREATE TABLE `products` (...)
     */
    protected static $mongoFieldTypes = [
        '_id' => 'objectId',
        'id' => 'int',
        'name' => 'string',
        'user_id' => 'int',
        'deleted_at' => 'date',
        'created_at' => 'date',
        'updated_at' => 'date',
        'status' => 'int',
        'meta_desc' => 'string',
        'summary' => 'string',
        'content' => 'string',
        'price' => 'int',
        'price1' => 'int',
        'param1' => 'int',
        'param2' => 'int',
        'param3' => 'int',
        'parent_id' => 'int',
        'parent_extra' => 'string',
        'parent_all' => 'string',
        'image_list' => 'string',
        'orders' => 'int',
        'meta' => 'string',
        'refer' => 'string',
        'tmp' => 'string',
        'type' => 'string',
    ];

    public function getLinkPublic()
    {

        //        cstring2::toSlug();
        return '/san-pham/'.Str::slug($this->name).'.'.$this->id.'.html';
    }

    public function getMetaDesc()
    {
        return strip_tags($this->meta_desc ?? $this->name);
    }


    public function getQuotaDateText()
    {
        $obj = \App\Models\ProductAttribute::where(['product_id' => $this->id,
            'attribute_name' => 'time_limit'
        ])->first();
        if($obj){
            $han = $obj->attribute_value;
            if(strstr($han, '.y')){
                $han = str_replace('.y', ' năm', $han);
            }
            if(strstr($han, '.d')){
                $han = str_replace('.d', ' ngày', $han);
            }
            if($han){
                return $han;
            }
        }
        return "NotFoundDate";
    }

    function  getQuotaSizeDownloadAllow()
    {
        $obj = \App\Models\ProductAttribute::where(['product_id' => $this->id,
            'attribute_name' => 'download_limit_size'
        ])->first();
        if($obj){
            $han = $obj->attribute_value;
            if(is_numeric($han)){
                return $han;
            }
        }
        return 0;
    }

    function  getQuotaCountDownloadAllow()
    {
        $obj = \App\Models\ProductAttribute::where(['product_id' => $this->id,
            'attribute_name' => 'download_limit_count'
        ])->first();
        if($obj){
            $han = $obj->attribute_value;
            if(is_numeric($han)){
                return $han;
            }
        }
        return 0;
    }


    public function getQuotaNHour()
    {
        $obj = \App\Models\ProductAttribute::where(['product_id' => $this->id,
            'attribute_name' => 'time_limit'
        ])->first();
        if($obj){
            $han = $obj->attribute_value;
            if(strstr($han, '.y')){
                $han = str_replace('.y', '', $han);
                if(is_numeric($han)){
                    return $han*365*24;
                }
            }
            if(strstr($han, '.d')){
                $han = str_replace('.d', '', $han);
                if(is_numeric($han)){
                    return $han*24;
                }
            }
            if(is_numeric($han)){
                return $han;
            }
        }
        return 0;
    }
}
