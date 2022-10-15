<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    use HasFactory;

    public function items()
    {
        return $this->belongsTo(Factura::class, 'factura_id');
    }
}
