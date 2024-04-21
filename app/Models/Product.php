<?php

namespace App\Models;
use App\Models\Category;
use App\Models\Shopkeeper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $fillable = ['name', 'description', 'price','category_id','image'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function shopkeeper()
    {
        return $this->belongsTo(Shopkeeper::class, 'shop_id');
    }
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
