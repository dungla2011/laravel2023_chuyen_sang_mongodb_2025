<?php

namespace App\Http\Controllers;

use App\Components\clsParamRequestEx;
use App\Models\CloudServer;

class CloudServerController extends BaseController
{
    protected CloudServer $data;

    public function __construct(CloudServer $data, clsParamRequestEx $objPrEx)
    {
        $this->data = $data;
        $this->objParamEx = $objPrEx;
    }

    public function tree_index()
    {
        $objMeta = $this->data::getMetaObj();

        return view('admin.default-tree', compact('objMeta'));
    }
}
