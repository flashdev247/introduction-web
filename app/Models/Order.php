<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'code',
        'customer_name',
        'customer_phone',
        'customer_email',
        'shipping_address_detail',
        'province_id',
        'province_name',
        'commune_id',
        'commune_name',
        'note',
        'subtotal',
        'total',
        'wants_invoice',
        'invoice_company',
        'invoice_tax_code',
        'invoice_email',
        'invoice_address',
        'status',
    ];

    protected $casts = [
        'wants_invoice' => 'boolean',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
