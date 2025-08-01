<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use LadLib\Laravel\Database\TraitModelExtra;

class EventUserInfo extends ModelGlxBase
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
        'user_id' => 'int',
        'status' => 'int',
        'created_at' => 'date',
        'updated_at' => 'date',
        'deleted_at' => 'date',
        'image_list' => 'string',
        'log' => 'string',
        'parent_id' => 'int',
        'parent_extra' => 'string',
        'parent_all' => 'string',
        'title' => 'string',
        'first_name' => 'string',
        'last_name' => 'string',
        'email' => 'string',
        'phone' => 'string',
        'address' => 'string',
        'organization' => 'string',
        'designation' => 'string',
        'language' => 'string',
        'extra_info1' => 'string',
        'extra_info2' => 'string',
        'extra_info3' => 'string',
        'extra_info4' => 'string',
        'extra_info5' => 'string',
        'signature' => 'string',
        'note' => 'string',
        'gender' => 'int',
    ];

    public $parent_text;
    public $org_text;

    function getFullname()
    {
        return "$this->last_name $this->first_name";
    }
    function getFullnameAndTitle()
    {
        return "$this->title $this->last_name $this->first_name";
    }

    public function getValidateRuleInsert()
    {
        return [
//            'email' => 'required|email|unique:event_user_infos,email',
            'email' => 'required|email|unique:event_user_infos,email,NULL,id,deleted_at,NULL',
        ];

    }

    public function getValidateRuleUpdate($id = null)
    {
        return [
            'email' => 'email|unique:event_user_infos,email,' . $id . ',id,deleted_at,NULL',
        ];

    }
}
