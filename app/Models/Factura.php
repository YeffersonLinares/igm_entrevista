<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;

    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:i:s',
    ];

    public function items()
    {
        return $this->hasMany(Items::class, 'factura_id', 'id');
    }
}
