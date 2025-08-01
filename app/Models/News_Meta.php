<?php

namespace App\Models;

use App\Components\Helper1;
use Illuminate\Support\Str;
use LadLib\Common\Database\MetaOfTableInDb;
use PhpOffice\PhpSpreadsheet\Writer\Ods\Meta;

class News_Meta extends MetaOfTableInDb
{
    protected static $api_url_admin = '/api/news';

    protected static $web_url_admin = '/admin/news';

    protected static $api_url_member = '/api/news-member';

    protected static $web_url_member = '/member/news';

    public static $folderParentClass = NewsFolder::class;

    public static $modelClass = News::class;

    public static $allowAdminShowTree = 1;

    public static $titleMeta = " Danh sách tin tức";

    public function _eml($obj, $val, $field)
    {
        return "$obj->email";
    }

    public function isStatusField($field)
    {
        if ($field == 'status') {
            return true;
        }

        return parent::isStatusField($field); // TODO: Change the autogenerated stub
    }

    public function getJoinField()
    {
        $mm = [
            'email1' => [
                'table' => 'users',
                'field' => 'email',
                'field_local' => 'user_id',
                'field_remote' => 'id',
            ],
        ];

        return $mm;
    }

    public function _email1()
    {
        //        return "\n xxx";
    }

    public function getPublicLink($objOrId)
    {

        if (is_object($objOrId)) {
            $obj = $objOrId;
        } else {
            if (! is_numeric($objOrId)) {
                $objOrId = qqgetIdFromRand_($objOrId);
            }
            $obj = News::find($objOrId);
        }

        $slug = Str::slug($obj->name);
        $link = '/tin-tuc/'.$slug.'.'.$obj->id.'.html';

        //        echo "\n <hr>  <h3>  <a class='news1' href='$link'> $obj->name </h3>
        return $link;
    }

    /**
     * @return MetaOfTableInDb
     */
    public function getHardCodeMetaObj($field)
    {
        $objMeta = new MetaOfTableInDb();

        //Riêng Data type của Field, Lấy ra các field datatype mặc định
        //Nếu có thay đổi sẽ SET bên dưới
        //        $objSetDefault = new MetaOfTableInDb();
        //        $objSetDefault->setDefaultMetaTypeField($field);
        //        $objMeta->dataType = $objSetDefault->dataType;

        if ($field == 'parent_id') {
            $objMeta->dataType = DEF_DATA_TYPE_TREE_SELECT;
            $objMeta->join_api = '/api/news-folder';
        }
        if ($field == 'options') {
            $objMeta->dataType = DEF_DATA_TYPE_HTML_SELECT_OPTION;
        }
        if ($field == 'publish_status') {
            $objMeta->dataType = DEF_DATA_TYPE_HTML_SELECT_OPTION;
        }
        if ($field == 'image_list') {
            $objMeta->dataType = DEF_DATA_TYPE_IS_MULTI_IMAGE_BROWSE;
        }

        if ($field == 'content') {
            $objMeta->dataType = DEF_DATA_TYPE_RICH_TEXT;
        }

        if ($field == 'summary') {
            $objMeta->dataType = DEF_DATA_TYPE_TEXT_AREA;
        }
        if ($field == 'status') {
            $objMeta->dataType = DEF_DATA_TYPE_STATUS;
        }

        return $objMeta;

    }

    public function _parent_id($obj, $valIntOrStringInt, $field)
    {
        //return " $val , $obj->id , $obj->parent ";

        //        if($field == 'parent_multi' || $field == 'parent_multi2')
        return parent::_parent_id_template($obj, $valIntOrStringInt, $field); // TODO: Change the autogenerated stub

        /*
        if (!$valIntOrStringInt)
            return null;

        $cls = get_called_class();

        $objFolder = new NewsFolder();

        if ($objFolder instanceof NewsFolder) ;
        $ret = '';
        $retApi = [];
        //if(strstr($valIntOrStringInt, ','))
        if ($valIntOrStringInt) {
            $valIntOrStringInt = trim(trim($valIntOrStringInt, ','));
            $mVal = explode(",", $valIntOrStringInt);


            if ($mm = $objFolder->whereIn("id", $mVal)->get()) {
                foreach ($mm as $obj) {
                    $mName = $obj->getFullPathParentObj(2);
                    $retApi[$obj->id] = $obj->name;
                    $retApi[$obj->id] = $name0 = implode("/", $mName);;
                    $ret .= "<span class='one_node_name' title='remove this: $obj->id' data-id='$obj->id' data-field='$field'> [x] $name0</span>";
                }
            }

        }

        if (Helper1::isApiCurrentRequest())
            return $retApi;
//        else
//            return "xxxxxx <span title='' class='all_node_name' data-field='$field'>$ret </span>";

        return $ret;
        */
    }

    public function _publish_status($obj, $val, $field)
    {
        return [
            0 => '---',
            1 => 'Xuất bản',
            2 => 'Cần sửa nội dung',
            3 => 'Không xuất bản',
            //            3=>"ABC3",
            //            4=>"ABC4",
        ];
    }

    public function _options($obj, $val, $field)
    {
        return [
            0 => '---',
            1 => 'Danh sách Top Trang Chủ',
            2 => 'Bài đầu tiên Trang chủ',
            //            3=>"ABC3",
            //            4=>"ABC4",
        ];
    }

    public function _image_list($obj, $val, $field)
    {
        return Helper1::imageShow1($obj, $val, $field);
        //        $meta = new DemoTbl_Meta();
        //        return $meta->_image_list2($obj, $val, $field);
    }

    public static function DEL__joinFuncImageId($obj, $val, $field)
    {

    }
    //
    //    function isNumberField($field) {
    //        $mm = ['number1', 'number2'];
    //        if(in_array($field, $mm))
    //            return 1;
    //        return 0;
    //    }
    //
    //    function isStatusField($field) {
    //        $mm = ['status'];
    //        if(in_array($field, $mm))
    //            return 1;
    //        return 0;
    //    }

}
