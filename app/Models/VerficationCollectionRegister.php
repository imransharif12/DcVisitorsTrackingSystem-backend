<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerficationCollectionRegister extends Model
{
    use HasFactory;
    protected $fillable = [
        'collection_name',
        'user_id',
    ];
}
