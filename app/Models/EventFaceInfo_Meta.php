<?php

namespace App\Models;

use App\Components\Helper1;
use App\Http\ControllerApi\EventInfoControllerApi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use LadLib\Common\Database\MetaOfTableInDb;
use LadLib\Common\UrlHelper1;
use PhpOffice\PhpSpreadsheet\Writer\Ods\Meta;

/**
 * ABC123
 * @param null $objData
 */
class EventFaceInfo_Meta extends MetaOfTableInDb
{
    protected static $api_url_admin = "/api/event-face-info";
    protected static $web_url_admin = "/admin/event-face-info";

    protected static $api_url_member = "/api/member-event-face-info";
    protected static $web_url_member = "/member/event-face-info";

    //public static $folderParentClass = EventFaceInfoFolderTbl::class;
    public static $modelClass = EventFaceInfo::class;

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
            $objMeta->dataType = DEF_DATA_TYPE_STATUS;
        }
        if($field == 'tag_list_id'){
            $objMeta->join_api_field = 'name';
//          $objMeta->join_func = 'joinTags';
            //EventFaceInfo edit, tag sẽ ko update được?
            $objMeta->join_relation_func = 'joinTags';
            $objMeta->join_api = '/api/tags/search';
            $objMeta->dataType = DEF_DATA_TYPE_ARRAY_NUMBER;
        }
        if($field == 'parent_extra' || $field == 'parent_all' ){
            $objMeta->dataType = DEF_DATA_TYPE_TREE_MULTI_SELECT;
            $objMeta->join_api = '/api/need_define';
//            $objMeta->join_func = 'App\Models\EventFaceInfoFolderTbl::joinFuncPathNameFullTree';
        }

        if($field == 'parent_id'){
            $objMeta->dataType = DEF_DATA_TYPE_TREE_SELECT;
            $objMeta->join_api = '/api/need_define';
//            $objMeta->join_func = 'App\Models\EventFaceInfoFolderTbl::joinFuncPathNameFullTree';
        }

        if ($field == 'image_list') {
            $objMeta->dataType = DEF_DATA_TYPE_IS_MULTI_IMAGE_BROWSE;
        }

        if ($field == 'face_vector') {
            $objMeta->dataType = DEF_DATA_TYPE_TEXT_AREA;
        }

        //Nếu không set thì lấy của parent default nếu có
        if(!$objMeta->dataType)
            if($ret = parent::getHardCodeMetaObj($field))
                return $ret;

        return $objMeta;
    }
    public function _image_list($obj, $val, $field)
    {
        return Helper1::imageShow1($obj, $val, $field);
    }


    //...
    public function getExtraDataEditFieldNameX1($field)
    {
        $html = '';
        if ($field == 'face_vector') {
            $html = "<button type='button' id='re_learn' class='btn btn-sm btn-info' title='Nhận dạng ảnh mới up vào ImageList, xong cần ấn nút Save - Ghi lại'> Nhận dạng lại </button>";
        }

        return $html;

    }

    public function executeBeforeIndex($param = null) {
        //get all id array only of EventUserInfo
        $arrEventFaceInfo = EventUserInfo::select('id')->get()->pluck('id')->toArray();
//        dump($arrEventFaceInfo);
        foreach ($arrEventFaceInfo as $id) {
            $obj = EventFaceInfo::where("user_event_id", $id)->first();
            if (!$obj) {
                $obj = new EventFaceInfo();
                $obj->user_event_id = $id;
                $obj->save();
            }
        }

    }

    function getSqlOrJoinExtraIndex(\Illuminate\Database\Eloquent\Builder &$x = null, $getSelect = 0)
    {
        return $x->leftJoin('event_user_infos', 'user_event_id', '=', 'event_user_infos.id')
            ->addSelect([
                'event_user_infos.email AS _email',
                'event_user_infos.first_name as _first_name',
                'event_user_infos.last_name as _last_name',
            ]);
    }

    function getMapJoinFieldAlias()
    {
        return [
            '_email'=>'event_user_infos.email',
            '_first_name'=>'event_user_infos.first_name',
            '_last_name'=>'event_user_infos.last_name',
        ];
    }

    public function getFullSearchJoinField()
    {
        return [
            'event_user_infos.first_name'  => "like",
            'event_user_infos.last_name'  => "like",
            'event_user_infos.email'   => "like",
            'event_user_infos.phone'   => "like",
        ];
    }

    public function _user_event_id($obj, $valIntOrStringInt, $field)
    {
        $objU = EventUserInfo::find($valIntOrStringInt);
        if(!$objU)
            return "Not found user : $valIntOrStringInt";
        $name = $objU->getFullname();
        $email = $objU->email;

        $_group_name = $objU->_group_name;
        $org = $objU->organization ? "<br>  $objU->organization" : '';
        $designation = $objU->designation ? " <br>  $objU->designation" : '';
        $_group_name = $_group_name ? "<br> Nhóm: $_group_name" : '';
        $uid1 = $objU->id;
        $module = Helper1::getModuleCurrentName();
        $ret = "<div data-code-pos='ppp17121128641' style='font-size: small; padding: 5px; color: royalblue; position: relative'>";
        $ret .= "$name
        <br>
        $objU->phone
        <br>
        $email
 $designation
 $org
 $_group_name
";
        $ret .= '';
        $ret .= '</div>';

        return $ret;
    }

    public function extraJsIncludeEdit($objData = null)
    {

        ?>

        <script>

            function reLearnFace(){

                // alert("Lấy các ảnh ra để học");
                //Lấy ra image_list id trong .input_value_to_post [name=image_list]
                let imgId = document.querySelector('.input_value_to_post[name="image_list"]').value;
                console.log("inputImageList: ", imgId);

                showWaittingIcon();

                // Tạo FormData để post
                let formData = new FormData();
                let imgLink = "https://events.dav.edu.vn/test_cloud_file?fid=" + imgId
                console.log(" Image link: ", imgLink);
                formData.append('image_list', imgLink);

                //Gọi API fetch để post imageList lên để lấy kết qua ve
                fetch('/api/event-face-info/reLearn', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: formData
                }).then( response => {
                    hideWaittingIcon();
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.text();
                }).then(data => {
                    hideWaittingIcon();
                    console.log("Relearn data: ", data);
                    try {
                        data = JSON.parse(data);
                    }
                    catch (e) {
                        console.error("Error parsing JSON: ", e);
                        alert("Có lỗi xảy ra khi phân tích dữ liệu trả về:\n\n " + data);
                        return;
                    }

                    if (data.status === 'success' ) {
                        showToastInfoTop("Học lại thành công!");
                        let face_vector = data.vector;
                        console.log("RET= ", face_vector);
                        // Có thể làm gì đó với dữ liệu trả về
                        //Set giá trị này cho textarea.input_value_to_post.text_area_edit
                        let textArea = document.getElementById('edit_text_area_face_vector');
                        if (textArea) {
                            textArea.value = face_vector; // Giả sử trả về face_vector
                            console.log("Updated face_vector: ", face_vector);
                        } else {
                            console.error("Không tìm thấy textarea để cập nhật face_vector.");
                        }

                        //Triger click id = save-one-data
                        let saveButton = document.getElementById('save-one-data');
                        if (saveButton) {
                            saveButton.click();
                        } else {
                            console.error("Không tìm thấy nút lưu để kích hoạt.");
                        }


                    } else {
                        alert("Học lại thất bại: " + data.message);
                    }
                }).catch(error => {
                    hideWaittingIcon();
                    console.error('There was a problem with the fetch operation:', error);
                    // showToastInfoTop(data)
                    alert("Có lỗi xảy ra khi học lại: " + error.message);
                })

            }

            document.addEventListener('DOMContentLoaded', function () {

                if (document.getElementById('re_learn')) {
                    console.log(" Relearn...");
                    document.getElementById('re_learn').addEventListener('click', function () {
                        // if (confirm("Bạn có chắc muốn học lại?"))
                        {
                            reLearnFace();
                        }
                    });
                }
            });


        </script>

<?php


    }


}
