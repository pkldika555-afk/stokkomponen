<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterKomponen extends Model
{
    protected $table = 'master_komponen';

    protected $fillable = [
        'kode_komponen',
        'nama_komponen',
        'tipe',
        'satuan',
        'stok_minimal',
        'rak',
        'lokasi',
        'id_departemen'
    ];

    public function mutasi()
    {
        return $this->hasMany(MutasiBarang::class, 'id_komponen');
    }
    public function departemen()
    {
        return $this->belongsTo(Departemen::class,'id_departemen');
    }
}
