<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use LadLib\Laravel\Database\TraitModelExtra;

class FileRefer extends ModelGlxBase
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
        'site' => 'string',
        'remote_id' => 'int',
        'remote_url' => 'string',
        'filesize' => 'int',
        'param1' => 'string',
        'param2' => 'string',
        'refer_obj' => 'string',
        'price_k' => 'int',
        'count_dl' => 'int',
        'make_torrent' => 'int',
    ];




}
