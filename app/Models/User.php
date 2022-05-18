<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public function companyInfo()
    {
        return $this->hasOne(Company::class, 'user_id','id');
    }

     public function vistors()
    {
        return $this->hasOne(VistorAccess::class, 'user_id','id');
    }
    public function verfication()
    {
        return $this->hasOne(Verfications::class, 'user_id','id');
    }

    public function collectionRegister()
    {
        return $this->hasOne(VerficationCollectionRegister::class, 'user_id','id');
    }

    public function criminal()
    {
        return $this->hasOne(VerficationCriminalRecord::class, 'user_id','id');
    }



    public function accessData()
    {
        return $this->hasOne(AccessData::class, 'user_id','id');
    }

     public function accessDataArea()
    {
        return $this->hasMany(AccessDataArea::class, 'user_id','id');
    }

    public function accessDataBuilding()
    {
        return $this->hasOne(AccessDataBuilding::class, 'user_id','id');
    }

    public function escort()
    {
        return $this->hasOne(EscortAuthorizedPerson::class, 'user_id','id');
    }

    public function authorizedPerson()
    {
        return $this->hasOne(ReportedAuthorizedPerson::class, 'user_id','id');
    }

     public function auditByDatacube()
    {
        return $this->hasOne(AuditByDatacube::class, 'user_id','id');
    }

    public function applicableDocument()
    {
        return $this->hasMany(ApplicableDocument::class, 'user_id','id');
    }

    public function acknowledgementReceipt()
    {
        return $this->hasOne(AcknowledgementReceipt::class, 'user_id','id');
    }

    public function returnConfirmation()
    {
        return $this->hasOne(ReturnConfirmation::class, 'user_id','id');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'f_name',
        'l_name',
        'birth_date',
        'passport_id',
        'id_card_image',
        'access_request',
        'category',
        'start_date',
        'end_date',
        'justification',
        'unlimited_access',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
