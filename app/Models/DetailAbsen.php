<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailAbsen extends Model
{
    protected $table = 'gaji_absen';

    protected $guarded = [];
    public $timestamps = false;
    use HasFactory;
}
