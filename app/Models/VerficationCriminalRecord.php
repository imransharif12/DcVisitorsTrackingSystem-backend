<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerficationCriminalRecord extends Model
{
    use HasFactory;
    protected $fillable = [
        'criminal_name',
        'user_id',
    ];
}
