<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'manufacture',
        'price',
        'plat',
        'description'
    ];

    public function rent()
    {
        return $this->hasMany('App\Models\Rent');
    }
}
