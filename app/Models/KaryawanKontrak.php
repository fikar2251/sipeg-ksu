<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KaryawanKontrak extends Model
{
    protected $table = 'pegawai';

    protected $guarded = [];
    public $timestamps = true;
    use HasFactory;
}
