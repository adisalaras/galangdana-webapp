<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fundraising extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'fundraiser_id',
        'category_id',
        'thumbnail',
        'about',
        'has_finished',
        'is_active',
        'target_amount',
    ];
}
