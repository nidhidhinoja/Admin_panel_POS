<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class Category extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = ['name', 'description', 'image'];
    public function shopkeeper()
    {
        return $this->belongsTo(Shopkeeper::class, 'shop_id');
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
