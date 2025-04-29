<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Matkul extends Model
{
    protected $table = 'matkuls';
    protected $primaryKey = 'kode_matkul';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'nama_matkul',
        'jam_mulai',
        'jam_selesai',
    ];
}
