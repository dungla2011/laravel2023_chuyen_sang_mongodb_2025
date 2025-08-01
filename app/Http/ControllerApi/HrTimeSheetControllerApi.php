<?php

namespace App\Http\ControllerApi;

use App\Components\clsParamRequestEx;
use App\Repositories\HrTimeSheetRepositoryInterface;
use Illuminate\Http\Request;

class HrTimeSheetControllerApi extends BaseApiController
{
    public function __construct(HrTimeSheetRepositoryInterface $data, clsParamRequestEx $objPrEx)
    {
        $this->data = $data;
        $this->objParamEx = $objPrEx;
    }

    public function update_multi(Request $request)
    {

        //Todo: *** cần Kiểm tra các user_id có thuộc cây user quản lý ko, tránh post sang user khác

        return parent::update_multi($request); // TODO: Change the autogenerated stub
    }
}
