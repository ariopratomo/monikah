<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groom extends Model
{
    use HasFactory;

    protected $fillable = [
        'nickname',
        'name',
        'parents_name',
        'address',
        'other_info',
        'facebook_link',
        'twitter_link',
        'instagram_link',
        'tiktok_link',
        'undangan_id'
    ];
}
