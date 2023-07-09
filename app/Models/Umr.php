<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Umr extends Model
{
    protected $table = 'umr';

    protected $guarded = [];
    public $timestamps = false;
    use HasFactory;
}
