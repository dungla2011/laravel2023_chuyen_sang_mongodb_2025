<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use LadLib\Laravel\Database\TraitModelExtra;

class HatecoCertificate extends ModelGlxBase
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
        'ho' => 'string',
        'ten' => 'string',
        'ngay_sinh' => 'date',
        'noi_sinh' => 'string',
        'gioi_tinh' => 'string',
        'dan_toc' => 'string',
        'quoc_tich' => 'string',
        'nganh_nghe' => 'string',
        'trinh_do' => 'string',
        'hinh_thuc' => 'string',
        'nam_tot_nghiep' => 'int',
        'xep_loai' => 'string',
        'so_qd_cong_nhan_tn' => 'string',
        'ngay_qd' => 'date',
        'ngay_cap_bang' => 'date',
        'so_hieu_bang_tn' => 'string',
        'so_vao_goc_cap_bang' => 'string',
        'co_so_dao_tao' => 'string',
    ];

}
