<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model
{
    use HasFactory;

    protected $primaryKey = 'users_id';

    protected $fillable = [
        'username',
        'email',
        'password',
        'role',
    ];

    public function saleOrders(): HasMany
    {
        return $this->hasMany(SaleOrder::class, 'user_id', 'users_id');
    }

    public function purchaseOrders(): HasMany
    {
        return $this->hasMany(PurchaseOrder::class, 'user_id', 'users_id');
    }
}