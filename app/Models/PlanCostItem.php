<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use LadLib\Laravel\Database\TraitModelExtra;

class PlanCostItem extends ModelGlxBase
{
    use HasFactory, SoftDeletes, TraitModelExtra;
    protected $guarded = [];

}
