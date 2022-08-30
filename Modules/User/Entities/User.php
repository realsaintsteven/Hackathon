<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Modules\Competition\Entities\Team;
use Tymon\JWTAuth\Contracts\JWTSubject;

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

    public function teamUsers()
    {
        return $this->belongsToMany(Team::class, 'team_user')
        ->latest();
    }

    public function teams()
{
    return $this->belongsToMany(Team::class)->latest();
}

    public function getJWTCustomClaims()
    {
        return [];
    }
    
    protected static function newFactory()
    {
        return \Modules\User\Database\factories\UserFactory::new();
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function($model) {
            $model->attributes['password'] = $model->password ? \Hash::make($model->password) : \Hash::make('password');
            // $model->attributes['parent_id'] = $model->parent_id ?? 1;
            $model->attributes['active'] = $model->active ?? 1;
            // $model->attributes['options'] = $model->options ?? collect(config('user.options'));
        });

        // static::created(function($model) {
        //     $model->vault()->create([]);
        //     try {
        //        $model->notify(new SignupNotification($model));
        //     } catch (\Exception $e) {
        //         \Log::info($e->getMessage());
        //     }
        // });
    }
}

