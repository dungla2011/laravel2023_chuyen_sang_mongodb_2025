<?php

namespace App\Models;

use App\Components\Helper1;
use App\Http\ControllerApi\EventInfoControllerApi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use LadLib\Common\cstring2;
use LadLib\Common\Database\MetaOfTableInDb;
use LadLib\Common\UrlHelper1;
use PhpOffice\PhpSpreadsheet\Writer\Ods\Meta;

/**
 * ABC123
 * @param null $objData
 */
class EventUserPayment_Meta extends MetaOfTableInDb
{
    protected static $api_url_admin = "/api/event-user-payment";
    protected static $web_url_admin = "/admin/event-user-payment";

    protected static $api_url_member = "/api/member-event-user-payment";
    protected static $web_url_member = "/member/event-user-payment";

    //public static $folderParentClass = EventUserPaymentFolderTbl::class;
    public static $modelClass = EventUserPayment::class;
    public static $titleMeta = "Thanh toán sự kiện";

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

        if($field == 'evidence'){
            $objMeta->dataType = DEF_DATA_TYPE_TEXT_AREA;
        }

        if($field == 'status'){
            $objMeta->dataType = DEF_DATA_TYPE_STATUS;
        }
        if($field == 'tag_list_id'){
            $objMeta->join_api_field = 'name';
//          $objMeta->join_func = 'joinTags';
            //EventUserPayment edit, tag sẽ ko update được?
            $objMeta->join_relation_func = 'joinTags';
            $objMeta->join_api = '/api/tags/search';
            $objMeta->dataType = DEF_DATA_TYPE_ARRAY_NUMBER;
        }
        if($field == 'parent_extra' || $field == 'parent_all' ){
            $objMeta->dataType = DEF_DATA_TYPE_TREE_MULTI_SELECT;
            $objMeta->join_api = '/api/need_define';
//            $objMeta->join_func = 'App\Models\EventUserPaymentFolderTbl::joinFuncPathNameFullTree';
        }

        if($field == 'parent_id'){
            $objMeta->dataType = DEF_DATA_TYPE_TREE_SELECT;
            $objMeta->join_api = '/api/need_define';
//            $objMeta->join_func = 'App\Models\EventUserPaymentFolderTbl::joinFuncPathNameFullTree';
        }

        //Nếu không set thì lấy của parent default nếu có
        if(!$objMeta->dataType)
            if($ret = parent::getHardCodeMetaObj($field))
                return $ret;

        return $objMeta;
    }


    function _image_list1($obj, $val, $field){
        return Helper1::imageShow1($obj, $val, $field);
    }

    function _bank_name($obj, $val, $field){
        $user_event_id = $obj->user_event_id;
        if(!$user_event_id)
            return "Not found user event id: $obj->user_event_id";
        $evu = EventUserInfo::find($user_event_id);
        if(!$evu)
            return "Not found user event id: $obj->user_event_id";
        $text = $evu->bank_name_text;
        return $text ? $text : "<div> &#9888; Chưa có thông tin ngân hàng</div>";
    }
    function _bank_account($obj, $val, $field){
        $user_event_id = $obj->user_event_id;
        if(!$user_event_id)
            return "Not found user event id: $obj->user_event_id";
        $evu = EventUserInfo::find($user_event_id);
        if(!$evu)
            return "Not found user event id: $obj->user_event_id";
        $text = $evu->bank_acc_number;
        return $text ? $text : "<div> &#9888; Chưa có thông tin ngân hàng</div>";
    }
    function _tax_number($obj, $val, $field){
        $user_event_id = $obj->user_event_id;
        if(!$user_event_id)
            return "Not found user event id: $obj->user_event_id";
        $evu = EventUserInfo::find($user_event_id);
        if(!$evu)
            return "Not found user event id: $obj->user_event_id";
        $text = $evu->tax_number;
        return $text ? $text : "<div> &#9888; Chưa có mã số thuế</div>";
    }

    public function extraContentIndexButton1($v1 = null, $v2 = null, $v3 = null)
    {
        $sname = $this->getSNameFromField('event_id');
        $key = "seby_$sname";
        if($evid = request($key))
            echo "<a title='Tải xuống Excel thanh toán của Sự kiện này' href='/tool1/_site/event_mng/download_payment_event.php?evid=$evid'><button class='float-right mt-2 ml-3 btn btn-sm btn-info' type='button'> Tải xuống Excel </button> </a> ";
    }

    function getSqlOrJoinExtraIndex(\Illuminate\Database\Eloquent\Builder &$x = null, $getSelect = 0)
    {
        if(Helper1::isMemberModule()){
            $mEventId = EventInfo::getEventIdListInDeparmentOfUser(getCurrentUserId());
            $x->whereIn('event_id',  $mEventId);
        }

        return $x
            ->leftJoin('event_user_infos', 'user_event_id', '=', 'event_user_infos.id')
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
            'event_user_infos.organization'  => "like",
            'event_user_infos.email'   => "like",
        ];
    }
    //...

    public function _user_event_id($obj, $valIntOrStringInt, $field)
    {
        $objU = EventUserInfo::find($valIntOrStringInt);
        if(!$objU)
            return "Not found user : $valIntOrStringInt";
        $img = "/images/code_gen/ncbd-event-$obj->event_id-".$objU->id.".png";

        if(!file_exists(public_path($img))){


//            echo "\n Not found IMG";
        }

        $_group_name = $obj->_group_name;

        $domain = UrlHelper1::getDomainHostName();
        $img = EventInfoControllerApi::genLinkQr($domain, $obj->event_id, $objU->email, $objU->id);

        $org = $objU->organization ? "<br>  $objU->organization" : '';
        $designation = $objU->designation ? " <br>  $objU->designation" : '';
        $_group_name = $_group_name ? "<br> Nhóm: $_group_name" : '';

        $uid1 = $objU->id;

        $module = Helper1::getModuleCurrentName();

        $ret = "<div data-code-pos='ppp17121128641' style='font-size: small; padding: 5px; color: royalblue; position: relative'>";
        $ret .= " <span class='uinfo_print' id='user_info_$uid1'>
  <a style='text-decoration: none' href='/$module/event-user-info/edit/$uid1' target='_blank'>
  <i class='fa fa-edit'></i>
  $objU->title $objU->last_name $objU->first_name
 </a>
 $designation
 $org
 $_group_name
";
        $ret .= '</span>';

        //document.cookie = "isShowQrCode
        //Nếu cookie này cho phép thì mới hiện ảnh:
        $display = ";display: none;";
        if( ($_COOKIE['isShowQrCode'] ?? '')  && $_COOKIE['isShowQrCode'] != 'false') {
            $display = ";display: block;";
//            echo(" isShowQrCode = " . $_COOKIE['isShowQrCode']);
        }

        $module = Helper1::getModuleCurrentName();


        $ret .= ' <DIV class="img_qr_code" style="height: 101px; '.$display.'"><img style="width: 100px" src="'.$img.'"></DIV>';
        $ret .= '</div>';

        return $ret;
    }

    public function extraContentIndex1($v1 = null, $v2 = null, $v3 = null)
    {

        $uid = getCurrentUserId();
        if(Helper1::isMemberModule()){
//            $mmEv = EventInfo::where('user_id', $uid)->latest()->get();
            $mmEv = EventInfo::getEventIdListInDeparmentOfUser($uid, 1);

        }
        else
            $mmEv = EventInfo::latest()->get();

        $linkOpt = UrlHelper1::getUriWithoutParam();
        $sname = $this->getSNameFromField('event_id');
        $key = "seby_$sname";

        EventInfo::getHtmlSelectEvent($linkOpt, $mmEv, $key);

        ?>

        <!--        <button title="Chọn các thành viên dưới đây để in mã QR" class="btn btn-sm btn-primary mb-3" id="print_qr_list"> In mã QR</button>-->



        <?php
    }

    public function _payed($obj, $valIntOrStringInt, $field) {

        $moneyVn = cstring2::toTienVietNamString3($valIntOrStringInt);
        return $moneyVn;

    }

    public function _event_id($obj, $valIntOrStringInt, $field) {

        $key = EventAndUser_Meta::getSearchKeyFromField('event_id');

        if(!request($key))
            if($objU = EventInfo::find($valIntOrStringInt)){
                $ret = "<div title='$objU->name' data-code-pos='ppp 1'style='font-size: small; padding: 5px; color: royalblue'>";
                $ret .= "" . cstring2::substr_fit_char_unicode($objU->name,0, 50,1);
                $ret .= '</div>';
                return $ret;
            }
//        return $valIntOrStringInt;
    }



    public function extraCssInclude()
    {
?>
        <style>

            .join_val div {
                padding: 10px;
                font-size: 80%;
            }
        </style>
    <?php
    $key = EventAndUser_Meta::getSearchKeyFromField('event_id');
    if(request($key)){
        ?>
        <style>


    div.cellHeader.event_id{
        display: none;
    }
    div[data-table-field=event_id]{
        display: none!important;
    }
</style>

    <?php
    }


    }
}
