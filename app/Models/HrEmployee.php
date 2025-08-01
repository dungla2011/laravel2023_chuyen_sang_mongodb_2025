<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use LadLib\Laravel\Database\TraitModelExtra;

class HrEmployee extends ModelGlxBase
{
    use HasFactory, SoftDeletes, TraitModelExtra;

    protected $guarded = [];

    //    protected $dateFormat = 'd-m-Y';

    public static $hrAllUserTimeSheet = [];

    public static function getDataHtmlToPrint($mId)
    {
    }

    public function getValidateRuleInsert()
    {
        return [
            'user_id' => 'required|integer|unique:'.$this->getTable(),
            'first_name' => 'sometimes|string|min:1|max:100',
            'phone_number' => 'sometimes|numeric|digits_between:10,11',
            'last_name' => 'sometimes|min:1|max:100|nullable',
        ];
    }

    public function getValidateRuleUpdate($id = null)
    {
        $mm = $this->getValidateRuleInsert();
        $mm['user_id'] = 'required|integer|unique:'.$this->getTable().",user_id,$id";
        //'username'=>'sometimes|required|regex:/\w*$/|alpha_dash|regex:/\w*$/|max:50|min:6|unique:users,username,'.$id,

        return $mm;
    }

    public function getChucVu()
    {
        if ($this->job_title) {
            $mt = new HrEmployee_Meta();
            $m1 = $mt->_job_title($this, null, null);

            if (isset($m1[$this->job_title])) {
                return $m1[$this->job_title];
            }
        }

        return null;
    }

    public function getSex()
    {
        if ($this->sex) {
            $mt = new HrEmployee_Meta();
            $m1 = $mt->_sex($this, null, null);

            if (isset($m1[$this->sex])) {
                return $m1[$this->sex];
            }
        }

        return null;
    }

    public function getSalary()
    {

        if ($this->job_title == 4) {

        }

    }
    /**
     * Define MongoDB field types
     * Auto-generated from SQL structure
     */
    protected static $mongoFieldTypes = [
        '_id' => 'objectId',
        'id' => 'int',
        'user_id' => 'int',
        'status' => 'int',
        'created_at' => 'date',
        'updated_at' => 'date',
        'deleted_at' => 'date',
        'image_list' => 'string',
        'id_card' => 'string',
        'idcard_date' => 'date',
        'idcard_place' => 'string',
        'address' => 'string',
        'address_permanent' => 'string',
        'birth_day' => 'date',
        'last_name' => 'string',
        'first_name' => 'string',
        'phone_number' => 'string',
        'insurance_id' => 'string',
        'log' => 'string',
        'work_status' => 'int',
        'job_title' => 'int',
        'group_time' => 'int',
        'parent_id' => 'int',
        'orders' => 'int',
        'admin_this_tree' => 'int',
        'sex' => 'int',
        'home_town' => 'string',
        'certificate' => 'string',
        'skill' => 'string',
        'father_name' => 'string',
        'father_birthday' => 'date',
        'father_occupation' => 'string',
        'father_work_place' => 'string',
        'mother_name' => 'string',
        'mother_birthday' => 'date',
        'mother_occupation' => 'string',
        'mother_work_place' => 'string',
        'spouse_name' => 'string',
        'spouse_birthday' => 'date',
        'spouse_occupation' => 'string',
        'spouse_work_place' => 'string',
        'relatives_name' => 'string',
        'relatives_birthday' => 'date',
        'height' => 'double',
        'weight' => 'double',
        'nation' => 'string',
        'str1' => 'string',
        'str2' => 'string',
        'str3' => 'string',
        'str4' => 'string',
        'str5' => 'string',
        'str6' => 'string',
        'str7' => 'string',
        'str8' => 'string',
        'str9' => 'string',
        'str10' => 'string',
        'str11' => 'string',
        'str12' => 'string',
    ];

}
