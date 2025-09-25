<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Photo extends Model
{
    // protected $fillable = [
    //     'user_id', 'image_path', 'description', 'published_at', 'prix'
    // ];

    protected $fillable = ['user_id', 'title', 'image_path', 
        'description', 'prix', 'published_at', 'category_id', 'status'];

    protected $casts = [
        'published_at' => 'datetime', // Cast published_at en objet Carbon
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
           return $this->belongsTo(Category::class);
    }

    // public function getWhatsappLinkAttribute()
    // {
    //     $phone = preg_replace('/\D/', '', $this->user->phone_number);
    //     $image_url = Storage::url($this->image_path);
    //     $message = urlencode("je suis intéressé par cette photo: $image_url");
    //     return "https://wa.me/{$phone}?text={$message}";
    // }

    public function getWhatsappLinkAttribute()
    {
        $phone = preg_replace('/\D/', '', $this->user->phone_number); // Supprime les caractères non numériques
        $photo_url = url(route('photos.show', $this->id)); // URL de la page de détail
        $message = urlencode("Je suis intéressé par cette photo : {$this->title} - $photo_url");
        return "https://wa.me/{$phone}?text={$message}";
    }
}