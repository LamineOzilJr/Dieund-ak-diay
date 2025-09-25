<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'phone_number', 'profile_photo', 'role',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function getProfilePhotoUrlAttribute()
    {
        return $this->profile_photo
            ? Storage::url($this->profile_photo)
            : 'https://ui-avatars.com/api/?name=' . urlencode($this->first_name . '+' . $this->last_name) . '&size=150';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}