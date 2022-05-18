<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnConfirmation extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'f_name',
        'l_name',
        'confirmation_signature',
        'signature_date',
    ]; 
}
