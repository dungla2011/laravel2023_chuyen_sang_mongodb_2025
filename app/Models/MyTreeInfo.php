<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use LadLib\Laravel\Database\TraitModelExtra;

class MyTreeInfo extends ModelGlxBase
{
    use HasFactory, TraitModelExtra; //SoftDeletes,

    protected $guarded = [];

    /**
     * Define MongoDB field types
     * Auto-generated from SQL structure
     */
    protected static $mongoFieldTypes = [
        '_id' => 'objectId',
        'id' => 'int',
        'id__' => 'string',
        'name' => 'string',
        'title' => 'string',
        'created_at' => 'date',
        'updated_at' => 'date',
        'deleted_at' => 'date',
        'user_id' => 'int',
        'tree_id' => 'int',
        'status' => 'int',
        'image_list' => 'string',
        'color_name' => 'string',
        'color_title' => 'string',
        'fontsize_name' => 'int',
        'fontsize_title' => 'int',
        'banner_name_margin_top' => 'int',
        'banner_name_margin_bottom' => 'int',
        'banner_title_margin_top' => 'int',
        'banner_title_margin_bottom' => 'int',
        'member_background_img' => 'string',
        'member_background_img2' => 'string',
        'banner_width' => 'int',
        'banner_height' => 'int',
        'banner_name_bold' => 'string',
        'banner_name_italic' => 'string',
        'banner_title_bold' => 'string',
        'banner_title_italic' => 'string',
        'banner_title_curver' => 'int',
        'banner_name_curver' => 'int',
        'banner_text_shadow_name' => 'string',
        'banner_text_shadow_title' => 'string',
        'banner_margin_top' => 'int',
        'title_before_or_after_name' => 'int',
        'tree_nodes_xy' => 'string',
        'minX' => 'int',
        'minY' => 'int',
        'show_node_name_one' => 'int',
        'show_node_title' => 'int',
        'show_node_birthday_one' => 'int',
        'show_node_date_of_death' => 'int',
        'show_node_image' => 'int',
        'node_width' => 'int',
        'node_height' => 'int',
        'space_node_x' => 'int',
        'space_node_y' => 'int',
        'font_size_node' => 'int',
    ];


    function getNodeWidth()
    {
        if(!$this->node_width)
            return 81;
        return $this->node_width;
    }
    function getNodeHeight()
    {
        if(!$this->node_height)
            return 132;
        return $this->node_height;
    }

    function getSpaceNodeX()
    {
        if(!$this->space_node_x)
            return 5;
        return $this->space_node_x;
    }
    function getSpaceNodeY()
    {
        if(!$this->space_node_y)
            return 50;
        return $this->space_node_y;
    }

    function getFontSizeNode()
    {
        if(!$this->font_size_node)
            return 12;
        return $this->font_size_node;
    }
//
    function initDefaultValue(){
        if(!$this->space_node_x)
            $this->space_node_x = 3;
    }
//        if(!$this->node_width)
//            $this->node_width = 81;
//        if(!$this->node_height)
//            $this->node_height = 132;
//        if(!$this->space_node_y)
//            $this->space_node_y = 50;
//        if(!$this->font_size_node)
//            $this->font_size_node = 13;
////        node_width
////    node_height
////    space_node_y
////    space_node_x
////    font_size_node
//    }

}
