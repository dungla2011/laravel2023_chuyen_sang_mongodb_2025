<?php

namespace App\Components;

use App\Models\SiteMng;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class ClassRandId2
{
    public static function getIdFromRand($rand)
    {
        return $rand;
    }

    public static function getRandFromId($id)
    {
        return $id;
    }
}
