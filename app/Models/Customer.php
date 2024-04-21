<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'phone_no', 'address', 'city'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function shopkeeper()
    {
        return $this->belongsTo(Shopkeeper::class, 'shop_id');
    }
}
