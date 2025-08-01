<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use LadLib\Laravel\Database\TraitModelExtra;

class HrConfigSessionOrgIdSalary extends ModelGlxBase
{
    use HasFactory, TraitModelExtra;

    protected $guarded = [];

    /**
     * Define MongoDB field types
     * Auto-generated from SQL structure
     */
    protected static $mongoFieldTypes = [
        '_id' => 'objectId',
        'id' => 'int',
        'name' => 'string',
        'session_type_id' => 'int',
        'user_id' => 'int',
        'orders' => 'int',
        'status' => 'int',
        'created_at' => 'date',
        'updated_at' => 'date',
        'deleted_at' => 'date',
        'image_list' => 'string',
        'log' => 'string',
        'org_id' => 'int',
        'job_title_id' => 'int',
        'salary_month' => 'int',
        'num1' => 'double',
        'num2' => 'double',
        'num3' => 'double',
        'num4' => 'double',
        'num5' => 'double',
        'num6' => 'double',
        'num7' => 'double',
        'num8' => 'double',
        'num9' => 'double',
        'num10' => 'double',
        'num11' => 'double',
        'num12' => 'double',
        'num13' => 'double',
        'num14' => 'double',
        'num15' => 'double',
        'num16' => 'double',
        'num17' => 'double',
        'num18' => 'double',
    ];
}
