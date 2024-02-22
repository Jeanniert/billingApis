<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $casts=[
        'product'=> 'array',
    ];
    protected $fillable = [
        'company_id',
        'customer_id',        
        'total',
        'tax',
        'totalWithTax',
        'subtotal',
        'correlative',
        'date',     
    ];

}
