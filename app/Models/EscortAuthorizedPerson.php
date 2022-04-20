<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EscortAuthorizedPerson extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'escort_f_name',
        'escort_l_name',
        'escort_badge_number',
        'escort_authorized_signature',
    ];  
}
