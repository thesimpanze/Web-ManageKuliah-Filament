<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tugas extends Model
{
    use HasFactory;
    
    protected $table = 'tugas';
    
    protected $fillable = [
        'kode_tugas',
        'nama_tugas',
        'matkul_id',
        'deadline',
        'deskripsi',
        'file_path',
    ];
    
    protected $casts = [
        'deadline' => 'datetime',
    ];
    
    /**
     * Get the matkul that owns the tugas.
     */
    public function matkul(): BelongsTo
    {
        return $this->belongsTo(Matkul::class);
    }
}