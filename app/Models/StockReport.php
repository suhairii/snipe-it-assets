<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockReport extends Model
{
    // Menghubungkan model ini dengan View Database Anda
    protected $table = 'v_final_stok_report';

    // Karena ini View, tidak ada primary key 'id' yang auto-increment
    public $incrementing = false;
    
    // View tidak memiliki kolom created_at/updated_at yang bisa ditulis
    public $timestamps = false;

    // Jika view tidak memiliki primary key, definisikan null (opsional tapi aman)
    protected $primaryKey = null;
}