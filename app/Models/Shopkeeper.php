<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shopkeeper extends Model
{
    protected $fillable = [
        'name',
        'shop_name',
        'email',
        'phone_number',
        'address',
        'password',
        'gst',
        'image',
        // Add other fillable fields as needed
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'shop_id');
    }
    public function customer()
    {
        return $this->hasMany(Customer::class, 'shop_id');
    }

    public function categories()
    {
        return $this->hasMany(Category::class, 'shop_id');
    }



    // Add any additional model methods or relationships here
}
