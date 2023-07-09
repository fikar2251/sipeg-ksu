<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusKaryawan extends Model
{
    protected $table = 'status_pekerjaan';

    protected $guarded = [];
    public $timestamps = false;
    use HasFactory;
}
