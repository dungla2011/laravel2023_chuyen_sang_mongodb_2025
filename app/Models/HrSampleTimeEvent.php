<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use LadLib\Laravel\Database\TraitModelExtra;

class HrSampleTimeEvent extends ModelGlxBase
{
    use HasFactory, SoftDeletes, TraitModelExtra;

    protected $guarded = [];

    /**
     * Define MongoDB field types
     * Auto-generated from SQL structure
     */
    protected static $mongoFieldTypes = [
        '_id' => 'objectId',
        'id' => 'int',
        'name' => 'string',
        'user_id' => 'int',
        'status' => 'int',
        'created_at' => 'date',
        'updated_at' => 'date',
        'deleted_at' => 'date',
        'image_list' => 'string',
        'log' => 'string',
        'time_frame' => 'string',
        'cat1' => 'int',
        'cat2' => 'int',
        'num1' => 'double',
        'num2' => 'double',
        'num3' => 'double',
        'num4' => 'double',
    ];

    public static $hrAllUserTimeSheet; //[userid][month] => []

    //Month: '2023-01', '2022-10' ...
    public static function FgetAllUserInfoInMonth($uid, $month, $catId = 0)
    {
        if (! $uid || ! $month) {
            return;
        }

        if (isset(self::$hrAllUserTimeSheet[$uid]) && isset(self::$hrAllUserTimeSheet[$uid][$month])) {
            return self::$hrAllUserTimeSheet[$uid][$month];
        }

        if (! self::$hrAllUserTimeSheet) {
            self::$hrAllUserTimeSheet = [];
        }
        if (! isset(self::$hrAllUserTimeSheet[$uid])) {
            self::$hrAllUserTimeSheet[$uid] = [$month];
        }

        $m1 = HrSampleTimeEvent::where(['user_id' => $uid])->where('time_frame', '>=', $month.'-01')->where('time_frame', '<', $month.'-32');
        if ($catId) {
            $m1->where('cat1', $catId);
        }

        $m1 = $m1->get();

        return self::$hrAllUserTimeSheet[$uid][$month] = json_decode(json_encode($m1->toArray()));
    }

    //n_session sẽ có dạng <name>_x_y, với name là tên gợi nhớ, x là số giờ của ca, y là số ca được tính
    public static function FgetTotalCaUserMonth($uid, $month, $orgId = 0)
    {
        $mm = self::FgetAllUserInfoInMonth($uid, $month, $orgId);
        $tt = 0;
        if ($mm) {
            foreach ($mm as $obj) {
                if ($obj->num4 && strstr($obj->num4, '_')) {
                    $mm = explode('_', $obj->num4);
                    //<name>_x_y , số y là [2], được coi là số cả nếu có
                    if ($mm && isset($mm[2]) && is_numeric($mm[2])) {
                        $tt += $mm[2];
                    } else {
                        $tt += 1;
                    }
                }
            }
        }

        return $tt;
    }
}
