<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvitedGuest extends Model
{
    use HasFactory;

    protected $fillable = [
        'undangan_id',
        'name',
        'address',
        'telephone_number',
        'email_address',
        'slug',
    ];
}
