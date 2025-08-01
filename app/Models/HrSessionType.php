<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use LadLib\Laravel\Database\TraitModelExtra;

class HrSessionType extends ModelGlxBase
{
    use HasFactory, TraitModelExtra;

    protected $guarded = [];

    public function getValidateRuleInsert()
    {

        //        if(!isIPDebug())
        //            return;
        //OK: '/^([^`\$<>]+)$/u'; //Chuỗi bất kỳ không chứa `$<>
        $sreg = '/^([^`\$*<>]+)$/u';

        return [
            'name' => 'required|regex:'.$sreg.'|max:5',
            'desc' => 'nullable|regex:'.$sreg.'|max:200',
        ];
    }

    public function getValidateRuleUpdate($id = null)
    {
        return $this->getValidateRuleInsert();
    }
    /**
     * Define MongoDB field types
     * Auto-generated from SQL structure
     */
    protected static $mongoFieldTypes = [
        '_id' => 'objectId',
        'id' => 'int',
        'name' => 'string',
        'desc' => 'string',
        'hour' => 'int',
        'created_at' => 'date',
        'updated_at' => 'date',
        'deleted_at' => 'date',
        'log' => 'string',
        'orders' => 'int',
        'num1' => 'double',
        'num2' => 'double',
        'num3' => 'double',
        'num4' => 'double',
    ];

}
