<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
     use HasFactory;

    protected $table='nilai';

    protected $fillable = ['mahasiswa_id','dosen_id','matakuliah_id','nilai_huruf','nilai_angka'];

    public function mahasiswa(){
        return $this->belongsTo(Mahasiswa::class,'mahasiswa_id');
    }
    public function dosen(){
        return $this->belongsTo(Dosen::class,'dosen_id');
    }
    public function matakuliah(){
        return $this->belongsTo(MataKuliah::class,'matakuliah_id');
    }

}
