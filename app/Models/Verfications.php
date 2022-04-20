<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Verfications extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'operator_name',
        'operator_signature',
        'signature_date',
    ];
}
