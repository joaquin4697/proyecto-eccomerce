<?php

namespace App\Models;
use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'address_id', 'status', 'total',
    ];

    protected $casts = [
    'status' => OrderStatus::class,
    'total' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_items')
            ->withPivot('quantity', 'unit_price');
    }

    public function recalculateTotal(): void
    {
        $this->total = $this->items->sum(fn ($item) => $item->quantity * $item->unit_price);
        $this->save();
    }
}