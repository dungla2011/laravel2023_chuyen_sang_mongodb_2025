<?php

namespace App\Http\Controllers;

use App\Components\clsParamRequestEx;
use App\Models\EventRegister;

class EventRegisterController extends BaseController
{
    protected EventRegister $data;

    public function __construct(EventRegister $data, clsParamRequestEx $objPrEx)
    {
        //Member không cần limit user, vi se limit theo department
        $objPrEx->need_set_uid = 0;
        $this->data = $data;
        $this->objParamEx = $objPrEx;
    }


    function verifyEmail()
    {
        return $this->getViewLayout('public.event-register');
    }
    function register()
    {
        return $this->getViewLayout('public.event-register');
    }

    public function tree_index()
    {
        $objMeta = $this->data::getMetaObj();

        return view('admin.default-tree', compact('objMeta'));
    }
}
