<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use LadLib\Laravel\Database\TraitModelExtra;

class ChangeLog extends ModelGlxBase
{
    use HasFactory, SoftDeletes, TraitModelExtra;

    protected $guarded = [];
    
    /**
     * Define MongoDB field types for ChangeLog model
     * Based on SQL: CREATE TABLE `change_logs` (...)
     */
    protected static $mongoFieldTypes = [
        '_id' => 'objectId',
        'id' => 'int',
        'created_at' => 'date',
        'updated_at' => 'date',
        'deleted_at' => 'date',
        'user_id' => 'int',
        'user_id_admin' => 'int',
        'change_log' => 'string',
        'tables' => 'string',
        'id_row' => 'int',
        'cmd' => 'string',
        'ip_address' => 'string',
        'tag_log' => 'string',
    ];

    public static function addLog1($userid, $text, $ip = null)
    {
        if (! $ip) {
            $ip = @$_SERVER['REMOTE_ADDR'];
        }
        $obj = new ChangeLog();
        $obj->change_log = $text;
        $obj->ip_address = $ip;
        $obj->user_id = $userid;
        $obj->save();
    }
}
