<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    use HasFactory;

    protected $primaryKey = 'supplier_id';

    protected $fillable = [
        'supplier_name',
        'contact_phone',
        'email',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'supplier', 'supplier_id');
    }

    public function purchaseOrders(): HasMany
    {
        return $this->hasMany(PurchaseOrder::class, 'supplier_id', 'supplier_id');
    }
}
