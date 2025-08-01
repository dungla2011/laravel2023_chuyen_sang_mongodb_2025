<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class ModelMetaInfo extends ModelGlxBase
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Define MongoDB field types
     * Auto-generated from SQL structure
     */
    protected static $mongoFieldTypes = [
        '_id' => 'objectId',
        'id' => 'int',
        'created_at' => 'date',
        'updated_at' => 'date',
        'table_name_model' => 'string',
        'field' => 'string',
        'sname' => 'string',
        'name' => 'string',
        'full_desc' => 'string',
        'order_field' => 'int',
        'dataType' => 'int',
        'is_hiden_input' => 'int',
        'show_in_index' => 'string',
        'show_get_one' => 'string',
        'searchable' => 'string',
        'sortable' => 'string',
        'editable' => 'string',
        'editable_get_one' => 'string',
        'readOnly' => 'string',
        'limit_user_edit' => 'string',
        'limit_dev_edit' => 'string',
        'insertable' => 'string',
        'join_func' => 'string',
        'join_api' => 'string',
        'join_api_field' => 'string',
        'admin_url' => 'string',
        'func_foreign_key_insert_update' => 'string',
        'is_select' => 'string',
        'css_class' => 'string',
        'css_cell_class' => 'string',
        'css' => 'string',
        'link_to_view' => 'string',
        'link_to_edit' => 'string',
        'primary' => 'string',
        'is_multilangg' => 'string',
        'get_not_show' => 'string',
        'join_relation_func' => 'string',
        'data_type_in_db' => 'string',
        'opt_field' => 'int',
        'join_func_model' => 'string',
        'width_col' => 'int',
    ];

    //Dùng chung meta cho mọi site:
    //    protected $connection = 'mysql_for_common';



    public function __construct(array $attributes = [])
    {
//        if(isDebugIp()){
//            ob_clean();
//            die("1122333 - " . SiteMng::isUseOwnMetaTable());
//        }

        // if(!SiteMng::isUseOwnMetaTable())
        //     $this->setConnection('mysql_for_common');
        parent::__construct($attributes);
    }


}
