<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use LadLib\Common\Database\MetaOfTableInDb;
use LadLib\Laravel\Database\TraitModelExtra;

defined("DEF_MAX_DOWNLOAD_DAY_GB") || define("DEF_MAX_DOWNLOAD_DAY_GB", 120);


class UserCloud extends ModelGlxBase
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
        'user_id' => 'int',
        'quota_size' => 'int',
        'quota_file' => 'int',
        'updated_at' => 'date',
        'deleted_at' => 'date',
        'created_at' => 'date',
        'location_store_file' => 'string',
        'glx_bytes_in_used' => 'int',
        'glx_files_in_used' => 'int',
        'quota_daily_download' => 'int',
        'quota_limit_data' => 'int',
        'glx_download_his' => 'string',
        'glx_shell' => 'string',
        'glx_uid' => 'int',
        'glx_gid' => 'int',
    ];

    /**
     * @param  $field
     * @return MetaOfTableInDb
     */

    /**
     * Tạo user cloud mặc định nếu chưa có
     *
     * @return UserCloud
     */
    public static function getOrCreateNewUserCloud($user_id, $gb = 1, $nfile = 1000)
    {
        if ($ret = UserCloud::where('user_id', $user_id)->first()) {
            return $ret;
        }
        $pr = ['user_id' => $user_id];
        //100MB
        $pr['quota_size'] = _GB * $gb;
        $pr['quota_file'] = $nfile;

        return UserCloud::create($pr);
    }

    function getQuotaDailyDownload()
    {
        if(!$this->quota_daily_download)
            return DEF_MAX_DOWNLOAD_DAY_GB;
        return $this->quota_daily_download;
    }


    /**
     * Lấy Đường dẫn lưu trữ file upload lên, của user
     *
     * @return mixed|string
     */
    public function getLocationFile()
    {

        $sid = getSiteIDByDomain();

        if ($this->location_store_file) {
            $locationStore = $this->location_store_file;
        } else { //$locationStore = DEF_BASE_FILE_UPLOAD_FOLDER."/". env('DB_DATABASE') . "/user_files_" . $this->user_id; ;
            //            $locationStore = DEF_BASE_FILE_UPLOAD_FOLDER."/". env('DB_DATABASE') . "/user_files";

            if($tmpFolder = SiteMng::getUploadTmpFolderGlx())
                $locationStore = $tmpFolder."/user_files/siteid_$sid";
            else
                $locationStore = DEF_BASE_FILE_UPLOAD_FOLDER."/user_files/siteid_$sid";

        }

        return $locationStore;
    }
}
