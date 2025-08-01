<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use LadLib\Laravel\Database\TraitModelExtra;

class DemoTbl extends ModelGlxBase
{
    use HasFactory, SoftDeletes, TraitModelExtra;

    protected $guarded = [];

    /**
     * Define MongoDB field types
     * Auto-generated from SQL structure
     */
    protected static $mongoFieldTypes = [
        '_id' => 'objectId',
        'deleted_at' => 'date',
        'id' => 'int',
        'created_at' => 'date',
        'updated_at' => 'date',
        'user_id' => 'int',
        'number1' => 'int',
        'number2' => 'int',
        'string1' => 'string',
        'string2' => 'string',
        'textarea1' => 'string',
        'textarea2' => 'string',
        'tag_list_id' => 'string',
        'status' => 'int',
        'parent_id' => 'int',
        'parent2' => 'int',
        'parent_multi' => 'string',
        'parent_multi2' => 'string',
        'image_list1' => 'string',
        'image_list2' => 'string',
        'orders' => 'int',
        'name' => 'string',
    ];

    // Các hàm Set, Get riêng của Model laravel
    //    public function setNumber1Attribute($number1){
    //        $this->attributes['number1'] = $number1 * 2;
    //    }
    //    public function getNumber1Attribute(){
    //        return 111;
    //    }

    public function getValidateRuleInsert()
    {
        return [
//            'user_id' => 'required|integer|unique:'.$this->getTable(),
            'name' => 'sometimes|min:0|max:50',
//            'phone_number' => 'sometimes|numeric|digits_between:10,11',
//            'last_name' => 'sometimes|min:1|max:100|nullable',
        ];
    }

    public function getValidateRuleUpdate($id = null)
    {
        $mm = $this->getValidateRuleInsert();
//        $mm['user_id'] = 'required|integer|unique:'.$this->getTable().",user_id,$id";
        //'username'=>'sometimes|required|regex:/\w*$/|alpha_dash|regex:/\w*$/|max:50|min:6|unique:users,username,'.$id,

        return $mm;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sub1()
    {
        return $this->hasMany(DemoSub1::class, 'demo_id');
    }

    /** Kiểu join Mới
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function _join_tags()
    {
        return $this->belongsToMany(Tag::class, 'demo_and_tag_tbls', 'demo_id', 'tag_id');
    }

    /** Kiểu join cũ
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function joinTags()
    {
        return $this->belongsToMany(TagDemo::class, 'demo_and_tag_tbls', 'demo_id', 'tag_id')->withTimestamps();
    }


    // Getter cho thuộc tính 'name'
    public function getString1Attribute($value)
    {
        return ($value);
        return strtoupper($value);
    }

    public function getNumber2Attribute($value)
    {
        return $value;

    }


}
