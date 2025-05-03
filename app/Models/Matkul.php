<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Matkul extends Model
{
    use HasFactory;
    
    protected $table = 'matkuls';
    
    protected $fillable = [
        'kode_matkul',
        'nama_matkul',
        'jam_mulai',
        'jam_selesai',
    ];

    protected $casts = [
        'jam_mulai' => 'datetime',
        'jam_selesai' => 'datetime',
    ];
    
    /**
     * Get the tugas for the matkul.
     */
    public function tugas(): HasMany
    {
        return $this->hasMany(Tugas::class);
    }
}