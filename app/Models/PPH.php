<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PPH extends Model
{
    protected $table = 'pph';

    protected $guarded = [];
    public $timestamps = false;
    use HasFactory;
}
