<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UndanganMaster extends Model
{
    use HasFactory;

    protected $fillable = [ 'music_id','user_id','expired_date','slug'];

    public function groom()
    {
        return $this->hasOne(Groom::class, 'undangan_id', 'id');
    }
    public function bride()
    {
        return $this->hasOne(Bride::class, 'undangan_id', 'id');
    }

    public function music()
    {
        return $this->belongsTo(Music::class);
    }

    public function location()
    {
        return $this->belongsTo(location::class);
    }

    public function Video()
    {
        return $this->belongsTo(video::class);
    }

    // hasMony agenda
    public function agenda()
    {
        return $this->hasMany(Agenda::class, 'undangan_id', 'id');
    }

    // hasMany love_story
    public function love_story(){
        return $this->hasMany(LoveStory::class, 'undangan_id', 'id');
    }

    // hasMany love_story
    public function invited_guest(){
        return $this->hasMany(InvitedGuest::class, 'undangan_id', 'id');
    }

}
