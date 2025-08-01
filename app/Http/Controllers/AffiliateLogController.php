<?php

namespace App\Http\Controllers;

use App\Components\clsParamRequestEx;
use App\Models\AffiliateLog;
use App\Models\SiteMng;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AffiliateLogController extends BaseController
{
    protected AffiliateLog $data;

    public function __construct(AffiliateLog $data, clsParamRequestEx $objPrEx)
    {
        $this->data = $data;
        $this->objParamEx = $objPrEx;
    }


    /**
    Đây là afffilate code
    sẽ đưa mã AF vào bang AffiliateLog
     * tạo cookie để lưu mã AF
     */
    public function aff_link(){

        $affCode = request("aff_code");
        $uid = getCurrentUserId();

        AffiliateLog::checkAffCode($uid, $affCode);

        return $this->getViewLayout('index.sandbox.public');
    }

    public function tree_index()
    {
        $objMeta = $this->data::getMetaObj();

        return view('admin.default-tree', compact('objMeta'));
    }
}
