<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcknowledgementReceipt extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'signature',
        'signature_date',
    ];  
}
