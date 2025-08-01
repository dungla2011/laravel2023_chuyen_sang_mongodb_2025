<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use LadLib\Laravel\Database\TraitModelExtra;

class QuizQuestion extends ModelGlxBase
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
        'answer' => 'string',
        'is_active' => 'int',
        'user_id' => 'int',
        'is_english' => 'int',
        'created_at' => 'date',
        'updated_at' => 'date',
        'deleted_at' => 'date',
        'summary' => 'string',
        'content' => 'string',
        'content_vi' => 'string',
        'content_textarea' => 'string',
        'draft' => 'string',
        'image_list' => 'string',
        'note' => 'string',
        'note_book' => 'string',
        'type' => 'int',
        'explains' => 'string',
        'hard_level' => 'int',
        'class' => 'string',
        'parent_id' => 'int',
        'parent_list' => 'string',
        'refer' => 'string',
        'tmp' => 'string',
        'obj_refer' => 'string',
        'log' => 'string',
        'cat1' => 'int',
        'cat2' => 'int',
    ];
}
