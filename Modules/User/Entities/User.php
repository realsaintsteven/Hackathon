<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory;

    protected $fillable = [
    'uid',
    'username',
    'firstname',
    'lastname',
    'gender_id',
    'birthday',
    'image',
    'address',
    'school',
    'level',
    'city',
    'phone',
    'email',
    'password',
    'matric_no',
    'course_study',
];
    protected $hidden = [
        'password', 'remember_token', 'email_verified_at'   ];

        protected $casts = [
            'email_verified_at' => 'datetime',
        ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
    
    protected static function newFactory()
    {
        return \Modules\User\Database\factories\UserFactory::new();
    }
}
