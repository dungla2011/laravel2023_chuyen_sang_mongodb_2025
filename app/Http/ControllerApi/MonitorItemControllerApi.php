<?php

namespace App\Http\ControllerApi;

use App\Components\clsParamRequestEx;
use App\Repositories\MonitorItemRepositoryInterface;

class MonitorItemControllerApi extends BaseApiController
{
    public function __construct(MonitorItemRepositoryInterface $data, clsParamRequestEx $objPrEx)
    {
        $this->data = $data;
        $this->objParamEx = $objPrEx;
    }
}
