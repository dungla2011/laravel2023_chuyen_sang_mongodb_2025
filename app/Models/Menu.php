<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends ModelGlxBase
{
    use HasFactory;

    protected $guarded = [];
    
    /**
     * Define MongoDB field types for Menu model
     * Based on SQL: CREATE TABLE `menus` (...)
     */
    protected static $mongoFieldTypes = [
        '_id' => 'objectId',
        'id' => 'int',
        'name' => 'string',
        'parent_id' => 'int',
        'created_at' => 'date',
        'updated_at' => 'date',
        'deleted_at' => 'date',
        'slug' => 'string',
        'site_id' => 'int',
        // Additional menu fields
        'url' => 'string',
        'target' => 'string',
        'icon' => 'string',
        'order' => 'int',
        'status' => 'int',
        'description' => 'string',
        'permission' => 'string',
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
}
