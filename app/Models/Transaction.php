<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'type',
    ];

    // Relasi ke tabel transaction_details
    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }

}
