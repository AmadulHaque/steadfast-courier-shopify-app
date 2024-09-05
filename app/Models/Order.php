<?php

namespace App\Models;

use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $casts = [
        'created_at' => 'date:d-m-Y',
    ];
    
    protected $fillable = [
        'user_id',
        'orderNumber',
        'orderId',
        'name',
        'email',
        'phone',
        'address',
        'total',
        'shipping',
        'tax',
        'discount',
        'steadFastAmount',
        'steadFastSend',
        'steadFastId',
        'steadFastStatus',
    ];

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }
}
