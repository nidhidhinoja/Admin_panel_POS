<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function shopkeeper()
    {
        return $this->belongsTo(Shopkeeper::class,'shop_id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function orderDetails()
    {
        return $this->hasMany(OrderDetails::class);
    }

}
