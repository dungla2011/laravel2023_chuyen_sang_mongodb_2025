<?php

namespace App\Models;

use App\Components\Helper1;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use LadLib\Common\Database\MetaOfTableInDb;
use PhpOffice\PhpSpreadsheet\Writer\Ods\Meta;

/**
 * ABC123
 * @param null $objData
 */
class TaskInfo_Meta extends MetaOfTableInDb
{
    protected static $api_url_admin = "/api/task-info";
    protected static $web_url_admin = "/admin/task-info";

    protected static $api_url_member = "/api/member-task-info";
    protected static $web_url_member = "/member/task-info";

    public static function enableAddMultiItem()
    {
        return 1;
    }

    public static $folderParentClass = TaskInfo::class;

    public static $modelClass = TaskInfo::class;

    public static $allowAdminShowTree = true;

    /**
     * @param $field
     * @return MetaOfTableInDb
     */
    public function getHardCodeMetaObj($field){

        $objMeta = new MetaOfTableInDb();

        //Riêng Data type của Field, Lấy ra các field datatype mặc định
        //Nếu có thay đổi sẽ SET bên dưới
        $objSetDefault = new MetaOfTableInDb();
        $objSetDefault->setDefaultMetaTypeField($field);

        $objMeta->dataType = $objSetDefault->dataType;

        if($field == 'status'){
            $objMeta->dataType = DEF_DATA_TYPE_HTML_SELECT_OPTION;
        }
        if($field == 'tag_list_id'){
            $objMeta->join_api_field = 'name';
//          $objMeta->join_func = 'joinTags';
            //TaskInfo edit, tag sẽ ko update được?
            $objMeta->join_relation_func = 'joinTags';
            $objMeta->join_api = '/api/tags/search';
            $objMeta->dataType = DEF_DATA_TYPE_ARRAY_NUMBER;
        }
        if($field == 'parent_extra' || $field == 'parent_all' ){
            $objMeta->dataType = DEF_DATA_TYPE_TREE_MULTI_SELECT;
            $objMeta->join_api = '/api/need_define';
//            $objMeta->join_func = 'App\Models\TaskInfoFolderTbl::joinFuncPathNameFullTree';
        }

        if($field == 'parent_id'){
            $objMeta->dataType = DEF_DATA_TYPE_TREE_SELECT;
            $objMeta->join_api = '/api/task-info';
//            $objMeta->join_func = 'App\Models\TaskInfoFolderTbl::joinFuncPathNameFullTree';
        }

        if ($field == 'assigned_to') {
            $objMeta->join_api_field = 'email';
            //            $objMeta->join_func = 'joinUserEmailUserId';
            $objMeta->join_api = '/api/user/search';
        }

        if ($field == 'file_list') {
            $objMeta->dataType = DEF_DATA_TYPE_IS_MULTI_IMAGE_BROWSE;
        }

        if ($field == 'description') {
            $objMeta->dataType = DEF_DATA_TYPE_RICH_TEXT;
        }

        //Nếu không set thì lấy của parent default nếu có
        if(!$objMeta->dataType)
            if($ret = parent::getHardCodeMetaObj($field))
                return $ret;

        return $objMeta;
    }

    public function _file_list($obj, $val, $field)
    {
        return Helper1::imageShow1($obj, $val, $field);
    }

    public function setDefaultValue($field)
    {
        if ($field == 'parent_id') {
            return 0;
        }
    }

    public function _assigned_to($objData, $value = null, $field = null)
    {
        return  User_Meta::search_user_email($objData, $value, $field);
    }

    function _image_list1($obj, $val, $field){
        return Helper1::imageShow1($obj, $val, $field);
    }

    public function _parent_id($obj, $valIntOrStringInt, $field)
    {
        //        if($field == 'parent_multi' || $field == 'parent_multi2')
        return parent::_parent_id_template($obj, $valIntOrStringInt, $field); // TODO: Change the autogenerated stub
    }

    function _status($obj, $val, $field){
        $mm = [
            'not_started' => 'Chưa thực hiện',
            'in_progress' => 'Đang thực hiện',
            'completed' => 'Đã hoàn thành',
            'pending' => 'Tạm dừng',
            'canceled' => 'Hủy bỏ',
        ];
        return $mm;
    }


    //...




}
