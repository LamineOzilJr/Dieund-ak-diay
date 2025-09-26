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

    // public function getWhatsappLinkAttribute()
    // {
    //     $phone = preg_replace('/\D/', '', $this->user->phone_number); // Supprime les caractères non numériques
    //     $photo_url = url(route('photos.show', $this->id)); // URL de la page de détail
    //     $message = urlencode("Je suis intéressé par cette photo : {$this->title} - $photo_url");
    //     return "https://wa.me/{$phone}?text={$message}";
    // }

     // Lien WhatsApp avec aperçu
    public function getWhatsappLinkAttribute()
    {
        if (!$this->user->phone_number) {
            return null;
        }

        $phone = $this->user->phone_number;
        // Nettoyer le numéro de téléphone (supprimer les espaces, etc.)
        $phone = preg_replace('/\s+/', '', $phone);
        
        $message = "Bonjour, je suis intéressé par votre photo : \"{$this->title}\"";
        $photoUrl = route('photos.show', $this);
        $imageUrl = Storage::url($this->image_path);
        
        // Encoder les URLs pour WhatsApp
        $encodedMessage = urlencode($message);
        $encodedPhotoUrl = urlencode($photoUrl);
        
        return "https://wa.me/{$phone}?text={$encodedMessage}%0A%0AVoir%20la%20photo%20:%20{$encodedPhotoUrl}";
    }

    // URL complète de l'image pour les métadonnées
    public function getFullImageUrlAttribute()
    {
        return url(Storage::url($this->image_path));
    }

    // URL canonique de la photo
    public function getCanonicalUrlAttribute()
    {
        return route('photos.show', $this);
    }
}