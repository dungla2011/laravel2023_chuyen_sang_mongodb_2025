<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use LadLib\Laravel\Database\TraitModelExtra;

class DownloadLog extends ModelGlxBase
{
    use HasFactory, SoftDeletes, TraitModelExtra;
    protected $guarded = [];

    /**
     * Define MongoDB field types for DownloadLog model
     * Based on SQL table structure
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
        'log' => 'string',
        'sid_download' => 'double',
        'file_refer_id' => 'int',
        'file_id' => 'int',
        'file_id_enc' => 'string',
        'filename' => 'string',
        'size' => 'int',
        'ip_request' => 'string',
        'ip_download_done' => 'string',
        'time_download_done' => 'date',
        'count_dl' => 'int',
        'sid_encode' => 'string',
        'price_k' => 'int',
        'user_id_file' => 'int',
    ];

}
