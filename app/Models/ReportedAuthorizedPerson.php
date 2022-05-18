<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportedAuthorizedPerson extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'f_name',
        'l_name',
        'badge_number',
        'signature',
    ];  
}
