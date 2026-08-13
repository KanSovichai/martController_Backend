<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;

    protected $table = 'order_items';

    protected $primaryKey = 'order_item_id';

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity_sold',
        'unit_price_sale',
    ];

    public function saleOrder(): BelongsTo
    {
        return $this->belongsTo(SaleOrder::class, 'order_id', 'order_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}
