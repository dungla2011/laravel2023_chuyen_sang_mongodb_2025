<?php

namespace App\Models;

use App\Components\Helper1;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use LadLib\Common\Database\MetaOfTableInDb;

/**
 * ABC123
 *
 * @param  null  $objData
 */
class Product_Meta extends MetaOfTableInDb
{
    protected static $api_url_admin = '/api/product';

    protected static $web_url_admin = '/admin/product';

    protected static $api_url_member = '/api/member-product';

    protected static $web_url_member = '/member/product';

    public static $folderParentClass = ProductFolder::class;

    public static $modelClass = Product::class;

    public static $titleMeta = 'Danh sách sản phẩm';

    public static $allowAdminShowTree = 1;

    /**
     * @return MetaOfTableInDb
     */
    public function getHardCodeMetaObj($field)
    {

//        if ($mt = parent::getHardCodeMetaObj($field)) {
//            return $mt;
//        }

        $objMeta = new MetaOfTableInDb();
        //Riêng Data type của Field, Lấy ra các field datatype mặc định
        //Nếu có thay đổi sẽ SET bên dưới
        $objSetDefault = new MetaOfTableInDb();
        $objSetDefault->setDefaultMetaTypeField($field);

        $objMeta->dataType = $objSetDefault->dataType;


        if ($field == 'type') {
            $objMeta->dataType = DEF_DATA_TYPE_HTML_SELECT_OPTION;
        }
        if ($field == 'status') {
            $objMeta->dataType = DEF_DATA_TYPE_STATUS;
        }
        if ($field == 'content' || $field == 'summary' || $field == 'meta') {
            $objMeta->dataType = DEF_DATA_TYPE_RICH_TEXT;
        }
        if ($field == 'image_list') {
            $objMeta->dataType = DEF_DATA_TYPE_IS_MULTI_IMAGE_BROWSE;
        }
        if ($field == 'summary') {
            //            $objMeta->dataType = DEF_DATA_TYPE_TEXT_AREA;
        }

        if ($field == 'tag_list_id') {
            $objMeta->join_api_field = 'name';
            //          $objMeta->join_func = 'joinTags';
            //Product edit, tag sẽ ko update được?
            $objMeta->join_relation_func = 'joinTags';
            $objMeta->join_api = '/api/tags/search';
            $objMeta->dataType = DEF_DATA_TYPE_ARRAY_NUMBER;
        }
        if ($field == 'parent_id') {
            $objMeta->dataType = DEF_DATA_TYPE_TREE_SELECT;
            $objMeta->join_api = '/api/product-folder';
        }

        return $objMeta;
    }


    public static $DEF_TYPE_PRODUCT_DOWNLOAD = 'download_4s';
    public static $DEF_TYPE_PRODUCT_THUOC_TOAN = 'thuoc_mr_toan';
    public static $DEF_TYPE_PRODUCT_MY_TREE = 'my_tree';


    function _refer($obj, $val)
    {
        $tmp = substr($val, 0, 50).'...';
        return "<div style='margin-left: 10px; font-size: 90%'><a href='$val' target='_blank' >$tmp</a></div>";
    }

    function _name($obj, $val)
    {
        $att = ProductAttribute_Meta::getSearchKeyFromField('product_id');
        $link = "/admin/product-attribute?$att=$obj->id";

        $str = '';

        $str .= "<div class='quantity-container' data-product-id='$obj->id'>";
        $str .= "    <button type='button' class='quantity-btn minus'>-</button>";
        $str .= "    <input type='text' class='quantity-input' value='0'>";
        $str .= "    <button  type='button' class='quantity-btn plus'>+</button>";
        $str .= "    <button class='buy-btn add-to-cart' type='button'>+ Giỏ Hàng </button>";
        $str .= "    <button class='buy-btn buy-this-product' type='button'>Mua</button>";
        $str .= "</div>";

        $mm = ProductAttribute::where("product_id", $obj->id)->get();
        if(count($mm)){
            $str .= ' <div data-code-pos="ppp1734591284359" style="padding: 10px; font-size: smaller">
            <a target="_blank" href="'.$link.'"> [ E ] </a>  <br> ';
            foreach ($mm AS $att){
                $str .= " $att->attribute_name = $att->attribute_value <br/> ";
            }
            $str .= "</div>";

        }
        return $str;

    }

    //Ví dụ kiểu download, thì attribute sẽ list tương ứng các attribute phù hợp
    //Vì attribute sẽ là download, hoặc các loại hàng hoá dịch vụ khác, có các thuộc tính khác nhau
    function _type($obj, $val)
    {
        $mm = [
            0 => "--- Chọn kiểu ---",
            self::$DEF_TYPE_PRODUCT_DOWNLOAD => "Kiểu download",
            self::$DEF_TYPE_PRODUCT_THUOC_TOAN=> "Kiểu Thuốc Mr Toàn",
            self::$DEF_TYPE_PRODUCT_MY_TREE=> "Kiểu MYTREE",
        ];

        return $mm;

    }

    /**
     * Mỗi kiểu SP có 1 list các attribute riêng
     * @param $prod
     * @return array|string[]
     */
    static function  getArrayAttributeOfProduct ($prod){
        if($prod->type == self::$DEF_TYPE_PRODUCT_DOWNLOAD){
            return $mm = [
                'download_limit_size' => ' Băng thông Tải GB',
                'download_limit_daily_size' => ' Băng thông Tải GB Ngày',
                'time_limit' => "Thời gian sử dụng",
                'download_limit_count' => "Số Lượt tải",
            ];
        }

        if($prod->type == self::$DEF_TYPE_PRODUCT_MY_TREE){
            return $mm = [
                'limit_time' => 'Thoi gian su dung',
                'limit_node' => 'Số lượng node',
            ];
        }

        return [];
    }

    public function getHeightTinyMce($field)
    {
        if ($field == 'summary' || $field == 'meta') {
            return 150;
        }

    }

    public function _image_list($obj, $val, $field)
    {
        return Helper1::imageShow1($obj, $val, $field);
    }

    public function getPublicLink($objOrId)
    {

        if (is_object($objOrId)) {
            $obj = $objOrId;
        } else {
            if (! is_numeric($objOrId)) {
                $objOrId = qqgetIdFromRand_($objOrId);
            }
            $obj = ProductFolder::find($objOrId);
        }

        $slug = Str::slug($obj->name);
        $link = '/san-pham/'.$slug.'.'.$obj->id.'.html';

        //        echo "\n <hr>  <h3>  <a class='news1' href='$link'> $obj->name </h3>
        return $link;
    }

    public function _parent_id($obj, $valIntOrStringInt, $field)
    {
        //return " $val , $obj->id , $obj->parent ";
        return parent::_parent_id_template($obj, $valIntOrStringInt, $field); // TODO: Change the autogenerated stub

        //        if($field == 'parent_multi' || $field == 'parent_multi2')

        /*
        if(!$valIntOrStringInt)
            return null;

        $cls = get_called_class();

        $objFolder = new ProductFolder();

        if($objFolder instanceof ProductFolder);
        $ret = '';
        $retApi = [];
        //if(strstr($valIntOrStringInt, ','))
        if($valIntOrStringInt)
        {
            $valIntOrStringInt = trim(trim($valIntOrStringInt,','));
            $mVal = explode(",", $valIntOrStringInt);


            if($mm = $objFolder->whereIn("id", $mVal)->get()){
                foreach ($mm AS $obj) {
                    $mName = $obj->getFullPathParentObj(2);
                    $retApi[$obj->id] = $obj->name;
                    $retApi[$obj->id] = $name0 = implode("/", $mName);;
                    $ret .= "<span class='one_node_name' title='remove this: $obj->id' data-id='$obj->id' data-field='$field'> [x] $name0</span>";
                }
            }

        }

        if(Helper1::isApiCurrentRequest())
            return $retApi;
//        else
//            return "xxxxxx <span title='' class='all_node_name' data-field='$field'>$ret </span>";

        return $ret;
        */
    }

    /**
     * Update lại all SKU string của từng sp, hoặc insert new
     * @param $product_id
     * @return void
     */
    public static function updateInsertSKUString($product_id)
    {
        $pid = $product_id;

        $mpv = \App\Models\ProductVariant::where('product_id', $product_id)->get();

        $mopt = [];
        foreach ($mpv as $pv) {
            // echo "<br/>\n- ($pv->id) $pv->name ";
            if (! isset($mopt[$pv->id])) {
                $mopt[$pv->id] = [];
            }
            $mpvo = \App\Models\ProductVariantOption::where('product_variant_id', $pv->id)->get();
            foreach ($mpvo as $pvo) {
                $mopt[$pv->id][] = $pvo->id;
                //      echo "<br/>\n  +  ($pvo->id) $pvo->name ";
            }
        }

        $cross = \Cartesian::build($mopt);

        foreach ($cross as $m1) {
            sort($m1);
            $str = ','.implode(',', $m1).',';
            //            echo "<br/>\n $str ";

            //Nếu không có SKU nào thì insert
            if (! \App\Models\Sku::where(['product_id' => $pid, 'product_opt_list' => $str])->first()) {
                $skuName = '';
                foreach ($m1 as $optId) {
                    if ($obj = ProductVariantOption::find($optId)) {
                        if ($obj1 = ProductVariant::find($obj->product_variant_id)) {
                            $skuName .= mb_strtolower($obj1->name).'';
                        }
                        $skuName .= '_'.mb_strtolower($obj->name).'-';
                    }
                }
                $skuName = trim($skuName, '_-');

                \App\Models\Sku::insert(['product_id' => $pid, 'product_opt_list' => $str, 'sku' => $skuName]);
            }
        }

        //Xóa các SKU không còn product_variant_id
        if (1) {
            if ($mm = \App\Models\Sku::where(['product_id' => $pid])->get()) {
                foreach ($mm as $sku) {
                    $sku->product_opt_list = trim($sku->product_opt_list, ',');
                    if ($sku->product_opt_list) {
                        $m1 = explode(',', $sku->product_opt_list);
                        if ($m1) {
                            foreach ($m1 as $num) {
                                if (! $num) {
                                    continue;
                                }
                                if (! \App\Models\ProductVariantOption::find($num)) {
                                    $sku->delete();
                                }
                            }
                        }
                    }
                }
            }
        }
        //        Sku::where(['product_id'=>$pid])->where('product_opt_list', ",,")->forceDelete();
    }

    public function _sku_list($obj, $billId, $valOrOpt)
    {

        if (Route::getCurrentRoute()->getActionMethod() == 'create') {
            return;
        }

        if(!$billId)
            return " not_bill_id";

        $billAndProd = OrderItem::where('order_id', $billId)->get();

        $idObj = $pid = $obj->id;
        if(!$obj)
            $idObj = $pid = 0;

        $m3 = ProductVariant::where('product_id', $pid)->get();
        //mVar lưu trữ các cột của bảng
        $mVar = [];
        if ($m3) {
            foreach ($m3 as $obj3) {
                $mVar[$obj3->name] = 1;
            }
        }

        $mm0 = Sku::where('product_id', $obj->id)->orderBy('product_opt_list', 'ASC')->get();
        $ret = '';
        $cc = 0;
        $mret = [];

//        echo "<br/>\n xxx = ". count($mm0);

        //Nếu không có SKU nào, nghĩa là lấy trực tiếp luôn từ sản phẩm
        if(count($mm0)) {
            foreach ($mm0 as $sku) {
                $cc++;
                //            if(!isset($mret[$cc]))
                //                $mret[$cc] = [];
                $ret .= "  $cc . $sku->product_opt_list - ";

                //            echo "<br/>\n  $sku->product_opt_list ";

                //$mm = SkusProductVariantOption::where("sku_id", $sku->id)->get();
                $m1 = explode(',', $sku->product_opt_list);
                $m1 = array_filter($m1);

                $mtmp = [];
                $strKey = '';
                foreach ($m1 as $optId) {
                    if (! $optId) {
                        continue;
                    }
                    if ($obj11 = ProductVariantOption::find($optId)) {
                        if ($obj12 = ProductVariant::find($obj11->product_variant_id)) {

                            //                        echo "<br/>\nxx  $optId / $obj11->product_variant_id";

                            $ret .= $obj12->name." ($obj12->id) ";
                            $ret .= ' - '.$obj11->name."($optId) | ";
                            $mtmp[$obj12->name] = "$obj11->name";
                            $strKey .= "$obj12->name - $obj11->name | ";
                        }
                    }
                    //                dump($mret[$cc]);
                }

                //            if(count($mtmp) < 1)
                //                continue;

                //Chỉ quan tâm key của mVar, ko quan tâm Value
                $mVar['Tồn kho'] = $mtmp['Tồn kho'] = $sku->quantity;
                $mVar['Giá gốc'] = $mtmp['Giá gốc'] = $sku->price;
                $mVar['SkuName'] = $mtmp['SkuName'] = $sku->sku;
                $mVar['SKUId'] = $mtmp['SKUId'] = $sku->id;
                if ($valOrOpt == 'select123') {
                    $mVar['Số lượng đặt hàng'] = $mtmp['Số lượng đặt hàng'] = 1;

                    $mVar['Giá bán'] = $mtmp['Giá bán'] = $sku->price;
                }

                ksort($mtmp);
                $mret[$strKey] = $mtmp;
                ksort($mret);
                //
                //            echo "<pre> >>> " . __FILE__ . "(" . __LINE__ . ")<br/>";
                //            print_r($mtmp);
                //            echo "</pre>";
                //            $mret[$cc] = implode(' | ', $mret[$cc]) . " | Tồn kho: $sku->quantity";

                $ret .= " | Tồn kho: $sku->quantity <br>";
            }
        }
        else{

//            echo "<br/>\n MVAL...";
//            $mVar[$obj->name] = $mtmp['Tồn kho'] = 0;
            $mVar['Tồn kho'] = $mtmp['Tồn kho'] = 0;
            $mVar['Giá gốc'] = $mtmp['Giá gốc'] = 0;
            $mVar['SkuName'] = $mtmp['SkuName'] = 0;
            $mVar['SKUId'] = $mtmp['SKUId'] = 0;
            $mVar['Số lượng đặt hàng'] = $mtmp['Số lượng đặt hàng'] = 1;
            $mVar['Giá bán'] = $mtmp['Giá bán'] = 0;

        }

        if(!count($mm0)){
//            echo "<br/>\n SKU EMPTY";
        }

        //        $ret = implode("<br>", $mret);
        //
        //        echo "<pre> >>> " . __FILE__ . "(" . __LINE__ . ")<br/>";
        //        print_r($mret);
        //        echo "</pre>";

        ?>
        <?php

            $ret = '';
        //if($mVar)

        if ($valOrOpt != 'select123')
        {
            $ret = "<a data-code-pos='ppp1679273624258' style='margin: 5px; display: inline-block' target='_blank' href='/admin/sku?seby_s2=$pid'>";
            $ret .= "<button type='button'> EDIT SKU, GIÁ, TỒN KHO... </button>";
            $ret .= '</a>';
        }

        $ret .= "<table data-code-pos='ppp1679207154319' class='tmp1 get_all_sku'>";
        $ret .= '<tr>';
        $ret .= '<th> STT </th>';

//        echo "<pre> >>> " . __FILE__ . "(" . __LINE__ . ")<br/>";
//        print_r($mVar);
//        echo "</pre>";
//
        if ($mVar) {
            foreach ($mVar as $k => $v) {
                $ret .= "<th style=''> $k   </th>";
            }
        }
        if ($valOrOpt == 'select123') {
            $ret .= "<th style=''> Chọn Mua </th>";
        }
        $ret .= '</tr>';

        $cc = 0;

        if(!count($mret)){
//            $ret .= "Chưa có SKU!";

                $ret .="<tr>
<td colspan='5'>
</td>
<td>
<span class='minus_one'> - </span>
  <input data-code-pos='ppp1734770258694' class='quantity_input' type='text' value='1' style='width: 60px'>
  <span class='plus_one'> +
</span>

</td>
<td>
<input class='price_input' type='text' value='$obj->price' style='width: 60px'>
</td>
<td style='text-align: center'> <input class='check_sku_one_to_buy' data-product-id='$obj->id' data-sku-id='' type='checkbox'> </td>
</tr>";
        }

        foreach ($mret as $m1) {
            //            if(count($m1) <3 )
            //                continue
            $cc++;
            $ret .= '<tr>';
            $ret .= "<td> $cc </td>";

            //                echo "<pre> >>> " . __FILE__ . "(" . __LINE__ . ")<br/>";
            //                print_r($m1);
            //                echo "</pre>";
            $cc = 0;
            foreach ($mVar as $k2 => $v) {
                $cc++;
                $value = '-';
                if (isset($m1[$k2])) {
                    $value = $m1[$k2];
                }
                if ($k2 == 'Số lượng đặt hàng') {
                    $value = " <span class='minus_one'> [-] </span>
  <input data-code-pos='ppp1734770216349' class='quantity_input' type='text' value='$value' style='width: 60px'> <span class='plus_one'>[+]
  </span>";
                }
                if ($k2 == 'Giá bán') {
                    $value = "<input class='price_input' type='text' value='$value' style='width: 60px'>";
                }

                $ret .= "<td> $value </td>";
            }

            if ($valOrOpt == 'select123') {
                $skuid = $m1['SKUId'];
                $ret .= "<td style='text-align: center'> <input class='check_sku_one_to_buy' data-sku-id='$skuid' type='checkbox'> </td>";
            }

            foreach ($m1 as $key => $val) {
                //                    $ret .= "<td>$key - $val</td>";
            }

            $ret .= '</tr>';
        }
        $ret .= '</table>';

        if (Route::getCurrentRoute()->getActionMethod() != 'edit') {
            return $ret;
        }

        $str = '';
        {
            $str = '';

            $str .= "<div class='top_info_div' style='border: 1px solid #ccc; padding: 10px; margin: 5px' data-prod-id='$idObj' data-api=''>
<b>SKU phân loại </b> (Ví dụ:  Nhóm Màu: trắng, xanh..., Nhóm RAM: 256, 512 GB ... ):
";

            $mm0 = ProductVariant::where('product_id', $obj->id)->get();
            //        dump($mm0);
            foreach ($mm0 as $prov) {
                $tbl = $prov->getTable();
                $str .= "<div class='group_product_option' style='' >";
                $str .= " <b> <label for=''>Tên Nhóm </label></b>
<input data-table='$tbl' title='ProductVariant $prov->id ' data-id='$prov->id' style='font-weight: bold;' value='$prov->name'><span title='remove' onclick='remove_one_opt(this)' class='remove_one_opt'> X </span>
<br>";
                $mm1 = ProductVariantOption::where('product_variant_id', $prov->id)->get();
                $str .= " <label class='phan_loai' for=''> Phân loại </label> ";
                foreach ($mm1 as $provOpt) {
                    if ($provOpt instanceof ModelGlxBase);
                    $tbl = $provOpt->getTable();
                    $str .= " <input title='ProductVariantOption $provOpt->id ' class='elm1' data-table='$tbl'  data-id='$provOpt->id' value='$provOpt->name'> <span onclick='remove_one_opt(this)' class='remove_one_opt'> X </span>";
                }
                $str .= "<br> <label for=''>  </label>  <input data-cmd='add_new_var' placeholder=' Thêm $prov->name mới ' style='' type='text'>
<button onclick='addNewOptionOfVariant(this)' data-cmd='add_new_var' type='button'>Thêm $prov->name</button>
";
                $str .= '  ';
                $str .= '</div>';
            }

            $tmp = new ProductVariant();
            $tbl = $tmp->getTable();

            $str .= "<div class='group_product_option' style='' >";
            $str .= " <b> <label class='new_name_g' for='' style='color: green'>Tên nhóm mới </label> </b>
<input title='' data-cmd='add_new_gr_sku' value='' placeholder='Tên nhóm mới'>  ";
            $str .= "<button onclick='addNewVariant(this)' data-cmd='add_new_gr_sku' type='button'>Thêm nhóm</button>";
            $str .= '</div>';

            $str .= " <br> <button id='saveProductOption1' type='button' onclick='saveProductOption($idObj)'>Ghi lại </button></div>";

            $str .= '';
            ?>

            <?php
        }

        return trim($ret, ',').' '.$str;

        return "SKU LIST, $obj->id ";
        //...
    }

    public function extraCssInclude()
    {
        ?>
        <style>
            .quantity-container {
                display: flex;
                align-items: center;
                width: 400px;
                margin: 10px;
            }
            .input_value_to_post.image_list{
                display: none;
            }
            .quantity-container button{
                color: white;
                background-color: dodgerblue;
                border-radius: 3px;
            }
            .buy-btn {

                border: 0px solid #ccc;
                margin-left: 5px;
                font-size: 90%;
            }
            .quantity-btn {
                font-size: 90%;
                width: 30px;
                /*height: 30px;*/
                /*font-size: 18px;*/
                text-align: center;
                /*line-height: 30px;*/
                cursor: pointer;
                border: 1px solid #ccc;
            }
            .quantity-input {

                width: 50px!important;
                height: 30px;
                padding: 3px 3px!important;
                text-align: center;
                font-size: 120%;
                font-weight: bold;
                color: royalblue!important;
                margin: 0 5px;
            }
        </style>
        <?php
    }

    public function extraJsIncludeEdit($objData = null)
    {

        ?>


        <?php

        self::extraJsInclude(); // TODO: Change the autogenerated stub
    }

    public function extraJsInclude()
    {
        ?>

        <script>
            // let token = jctool.getCookie('_tglx863516839');
            document.addEventListener('DOMContentLoaded', () => {
                // Sự kiện click cho nút tăng giảm số lượng
                document.querySelectorAll('.quantity-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        const input = this.parentElement.querySelector('.quantity-input');
                        let value = parseInt(input.value);
                        if (this.classList.contains('minus')) {
                            value = Math.max(0, value - 1);
                        } else if (this.classList.contains('plus')) {
                            value = value + 1;
                        }
                        input.value = value;
                    });
                });

                // Sự kiện click cho nút "Thêm vào Giỏ hàng"
                document.querySelectorAll('.add-to-cart').forEach(button => {
                    button.addEventListener('click', function() {
                        const container = this.parentElement;
                        const product_id = container.getAttribute('data-product-id');
                        const quantity = container.querySelector('.quantity-input').value;

                        console.log("productId = ", product_id, " quantity = ", quantity);

                        // Gửi yêu cầu AJAX để thêm vào giỏ hàng
                        fetch('/api/cart/add_to_cart', {
                            method: 'POST',
                            headers: {
                                // Thêm token vào header
                                'Authorization': 'Bearer ' + token,
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({ product_id, quantity })
                        })
                        .then(response => {
                            // Lưu lại HTTP status để xử lý sau
                            const httpStatus = response.status;
                            return response.json().then(data => ({
                                data,
                                httpStatus
                            }));
                        })
                        .then(({ data, httpStatus }) => {
                            if (httpStatus === 200 && data.code) {
                                console.log("data = ", data);
                                showToastInfoTop(data.message)
                            } else {
                                alert('- Có lỗi xảy ra: HTTP ' + httpStatus + '\n- Message: ' + (data.message || 'Không xác định'));
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Đã xảy ra lỗi khi kết nối tới server');
                        });

                    });
                });

                // Sự kiện click cho nút "Mua"
                document.querySelectorAll('.buy-this-product').forEach(button => {
                    button.addEventListener('click', function() {
                        const container = this.parentElement;
                        const productId = container.getAttribute('data-product-id');
                        const quantity = container.querySelector('.quantity-input').value;
                        console.log("productId = ", productId, " quantity = ", quantity);
                        // Gửi yêu cầu AJAX để mua sản phẩm
                        fetch('/api/order/buy', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({ productId, quantity })
                        })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    alert('Đã mua sản phẩm');
                                } else {
                                    alert('Có lỗi xảy ra');
                                }
                            });
                    });
                });
            });
        </script>

        <script>

            let token = jctool.getCookie('_tglx863516839');

            // window.addEventListener('load',  function ()
            {
                console.log(" Load extraJsInclude ... ");

                function remove_one_opt(e){
                    let inputLeft = $(e).prev();
                    console.log("Click remove.. " , inputLeft);
                    if(inputLeft.attr('data-table') == 'product_variants'){
                        // $(e).parent('.group_product_option').find('*').hide()
                        $(e).parent('.group_product_option').find('input').hide()
                        $(e).parent('.group_product_option').find('span').hide()
                        $(e).parent('.group_product_option').find('button').hide()
                    }
                    inputLeft.hide();
                    $(e).remove()

                    // $(e).parent('.group_product_option').hide()
                }

                function saveProductOption(productId){

                    let mm = [];
                    console.log(" Save... ");
                    $(".group_product_option").each(function (){
                        if($(this).find("input[data-cmd=add_new_gr_sku]").length > 0)
                            return;

                        let proVar = $(this).find('input[data-table=product_variants]').first();
                        let proVarId = proVar.attr('data-id');
                        if(!proVar.is(':visible')){
                            proVarId = -1 * proVarId;
                        }

                        let name = proVar.val()
                        let gOpt = []
                        console.log("--- proVarId = ", proVarId, name);
                        $(this).find('input.elm1').each(function (){

                            let proVarOptionId = $(this).attr('data-id');
                            if(!$(this).is(':visible')){
                                proVarOptionId = -1 * proVarOptionId;
                            }

                            // let val = $(this).attr('value');
                            let name = $(this).val();
                            gOpt.push({id: proVarOptionId, name: name})
                            console.log(" + proVarOptionId = ", proVarOptionId, name);
                        })
                        mm.push({ id: proVarId, name: name , all_opt : gOpt })

                    })

                    showWaittingIcon();
                    let url = '/api/member-order-info/setOptionProduct?productId=' + productId;
                    $.ajax({
                        url: url,
                        type: 'POST',
                        beforeSend: function (xhr) {
                            xhr.setRequestHeader('Authorization', 'Bearer ' + token);
                        },
                        data: {mm},
                        success: function (data, status) {

                            hideWaittingIcon();
                            showToastInfoTop(data.payload)
                            console.log("Data: ", data, " \nStatus: ", status);
                        },
                        error: function (data) {
                            hideWaittingIcon();
                            console.log(" Eror....");
                            console.log(" DATAx ", data);
                            if (data.responseJSON && data.responseJSON.message)
                                alert('Error call api: ' + "\n" + data.responseJSON.message)
                            else
                                alert('Error call api: ' + "\n" + url + "\n\n" + JSON.stringify(data).substr(0, 1000));

                        },
                    });

                    console.log(" mm , ", mm);
                }

                function addNewVariant(e){

                    let thisInputNew =  $(e).siblings("input[data-cmd=add_new_gr_sku]").first();
                    let newValueStr = thisInputNew.val()

                    if(!newValueStr){
                        alert("Cần Nhập khác rỗng!");
                        thisInputNew.focus();
                        return;
                    }
                    let trungLap = 0
                    $('input[data-table=product_variants]').each(function (){
                        if($(this).val() == newValueStr){
                            trungLap = newValueStr;
                            return;
                        }
                    });
                    if(trungLap){
                        alert("Đã có tên này: " + trungLap);
                        return;
                    }

                    thisInputNew.val('')
                    let parent1 = $(e).parent();
                    let newGroup = $('<div class="group_product_option" style=""> <b> <label for="">Tên Nhóm </label></b>' +
                        '<input data-table="product_variants" data-id="" style="font-weight: bold;" value=""> <span onclick="remove_one_opt(this)" class="remove_one_opt"> X </span>' +
                        '<br> <label class="phan_loai" for=""> Phân loại </label>  <br> <label for="">  </label>' +
                        '<input data-cmd="add_new_var" placeholder=" Thêm mới ' + newValueStr + ' " style="" type="text">' +
                        '<button onclick="addNewOptionOfVariant(this)" data-cmd="add_new_var" type="button">Thêm ' + newValueStr + '</button>' +
                        '</div>');

                    newGroup.insertBefore(parent1);
                    //<input data-table="product_variants" data-id="2" style="font-weight: bold;" value="Màu">
                    newGroup.find("label.new_name_g").text("Tên nhóm").css("color","red");
                    newGroup.find("input").first().val(newValueStr).css("color","red");

                    let sampleInput ;//= $("input[data-cmd=add_new]").first().clone();
                    sampleInput = $('<input data-cmd="add_new_var" data-id="" value="">');
                    // sampleInput.attr("data-table", '1')
                    // sampleInput.prop("data-table", '1')

                    let sampleButton;// = $("button[data-cmd=add_new]").first().clone();
                    sampleButton = $('<button onclick="addNewOptionOfVariant(this)" data-cmd="add_new_var" type="button">Thêm </button>');
                    sampleButton.text("Thêm " + newValueStr);
                    // sampleButton.attr("data-table", '1')
                    // sampleButton.attr("data-cmd", '')
                    sampleInput.attr("placeholder", "Thêm " + newValueStr + " mới");
                    $("<br><label class='phan_loai'></label><br><label class=''></label>").appendTo(newGroup);
                    newGroup.find("button[data-cmd=add_new_gr_sku]").remove();

                    // sampleInput.appendTo(newGroup);
                    // sampleButton.appendTo(newGroup);
                }

                function addNewOptionOfVariant(e){
                    let cmd = $(e).attr("data-cmd")
                    let tbl = $(e).attr("data-table")

                    let thisInputNew =  $(e).siblings("input[data-cmd=add_new_var]").first();
                    //thisInputNew = $('<input class="elm1" data-table="product_variant_options"  data-id="" value="">');
                    let newValueStr = thisInputNew.val() //attr('value')
                    if(!newValueStr){
                        alert("Cần Nhập khác rỗng!");
                        thisInputNew.focus();
                        return;
                    }

                    let trungLap = 0
                    $(e).siblings("input.elm1").each(function (){
                        if($(this).val() == newValueStr){
                            trungLap = newValueStr;
                            return;
                        }
                    });

                    if(trungLap){
                        alert("Đã có tên này: " + trungLap);
                        return;
                    }
                    let parent1 = thisInputNew.parent();
                    console.log("PR = ", parent1);
                    let newInput = $('<input class="elm1" data-table="product_variant_options"  data-id="" value=""> <span onclick="remove_one_opt(this)" class="remove_one_opt"> X </span>');
                    newInput.val(newValueStr);
                    newInput.addClass("elm1")
                    newInput.css("color", "red")
                    newInput.css("border", "1px solid red")
                    if($(e).siblings("input.elm1").last().length){
                        newInput.insertAfter($(e).siblings("input.elm1").last())
                    }
                    else{
                        newInput.insertAfter($(e).siblings("label.phan_loai").first())
                    }

                    thisInputNew.val('').focus();

                    console.log("CMD1 = " , cmd, tbl, newValueStr);
                }
            }

            // );

        </script>

        <script>

            $("#saveProductOption1").on('click', function (){

                console.log(" saveProductOption1 ... ");




            })

        </script>

        <style>
            .top_info_div input {
                background-color: white!important;  margin-top: 5px; border: 1px solid #ccc!important; width: 100px!important;
                margin-right: 5px;
            }
            .top_info_div label {
                min-width: 100px;
            }
            .top_info_div .group_product_option {
                background-color: snow; border: 1px solid #ccc; padding: 10px; margin-top: 10px
            }

        </style>
        <?php

    }
}
