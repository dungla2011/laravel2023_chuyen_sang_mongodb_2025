<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class ModelMetaInfo extends ModelGlxBase
{
    use HasFactory;

    protected $guarded = [];

    //Dùng chung meta cho mọi site:
    //    protected $connection = 'mysql_for_common';



    public function __construct(array $attributes = [])
    {
//        if(isDebugIp()){
//            ob_clean();
//            die("1122333 - " . SiteMng::isUseOwnMetaTable());
//        }

        if(!SiteMng::isUseOwnMetaTable())
            $this->setConnection('mysql_for_common');
        parent::__construct($attributes);
    }


}
