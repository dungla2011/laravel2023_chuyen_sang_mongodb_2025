<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use LadLib\Laravel\Database\TraitModelExtra;

class CloudServer extends ModelGlxBase
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
        'domain' => 'string',
        'proxy_domain' => 'string',
        'mount_list' => 'string',
        'mount_list_disable_rep' => 'string',
        'replicate_now' => 'int',
        'iscache' => 'int',
        'comment' => 'string',
        'enable' => 'int',
        'file_service_port' => 'int',
        'created_at' => 'date',
        'updated_at' => 'date',
        'deleted_at' => 'date',
    ];

    static function getProxyDomainServer($domainServer)
    {
        return self::where('domain', $domainServer)->first()?->proxy_domain;
    }

    static function getServerDomainAndProxy()
    {
        return \App\Models\CloudServer::where("enable", 1)->pluck('proxy_domain', 'domain')->toArray();
    }


}
