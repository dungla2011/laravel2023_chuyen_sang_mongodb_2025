<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use LadLib\Laravel\Database\TraitModelExtra;

class MediaItem extends ModelGlxBase
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
        'parent_id' => 'int',
        'parent_list' => 'string',
        'parent_extra' => 'string',
        'parent_all' => 'string',
    ];

    public function _folders(): BelongsToMany
    {
        // Chỉ định rõ tên khóa ngoại trong bảng pivot
        return $this->belongsToMany(MediaFolder::class, 'media_items_folders', 'media_item_id', 'media_folder_id')
            ->withPivot('is_primary')
            ->withTimestamps();
    }
    public function _authors(): BelongsToMany
    {
        // Chỉ định rõ tên khóa ngoại trong bảng pivot
        return $this->belongsToMany(  MediaAuthor::class , 'media_items_authors', 'media_item_id', 'media_author_id')
            ->withTimestamps();
    }

    public function _actors(): BelongsToMany
    {
        // Chỉ định rõ tên khóa ngoại trong bảng pivot
        return $this->belongsToMany(  MediaActor::class , 'media_items_actors', 'media_item_id', 'media_actor_id')
            ->withTimestamps();
    }

    function getLink1()
    {
        return "/movie/item/".Str::slug($this->name).".".$this->id;
    }

    public function getCategory(){
        return $this->_folders;
    }


}
