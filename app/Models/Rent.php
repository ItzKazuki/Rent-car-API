<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rent extends Model
{
    use HasFactory;

    protected $fillable = [
        'rent_name',
        'date_borrow',
        'date_return',
        'down_payment',
        'discount',
        'total_price'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
