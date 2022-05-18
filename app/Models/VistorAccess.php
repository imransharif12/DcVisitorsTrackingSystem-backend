<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VistorAccess extends Model
{
    use HasFactory;
    protected $fillable = [
        'v_f_name',
        'v_l_name',
        'date',
    ];
}
