<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departemen extends Model
{
    protected $table = 'departemen';

    protected $guarded = [];
    public $timestamps = true;

    use HasFactory;
}
