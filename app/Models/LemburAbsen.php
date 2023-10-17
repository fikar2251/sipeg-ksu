<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LemburAbsen extends Model
{
    protected $table = 'lembur_absen';

    protected $guarded = [];
    public $timestamps = false;
    use HasFactory;
}
