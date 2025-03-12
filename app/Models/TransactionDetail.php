<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransactionDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'clothes_id',
        'size_id',
        'quantity',
    ];

   // Relasi ke tabel transactions
   public function transaction()
   {
       return $this->belongsTo(Transaction::class);
   }

   // Relasi ke tabel clothes
   public function clothes()
   {
       return $this->belongsTo(Clothes::class);
   }

   // Relasi ke tabel sizes
   public function size()
   {
       return $this->belongsTo(Size::class);
   }
}
