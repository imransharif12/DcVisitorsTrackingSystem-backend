<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Company extends Authenticatable
{
    use HasFactory,HasApiTokens;
    
    protected $fillable = [
        'company',
        'position',
        'email',
        'phone',
        'address',
        'city',
        'zipcode',
        'country',
    ];
}
