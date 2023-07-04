<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Import extends Model
{
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    // ];
    protected $table = 'presensi';
    protected $guarded = [];
    public $timestamps = false;

    use HasFactory;
}
