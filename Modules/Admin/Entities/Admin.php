<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Spatie\Permission\Traits\HasRoles;

use Modules\Product\Entities\Product;

use Modules\Admin\Notifications\PasswordResetNotification;



class Admin extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'active',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'active' => 'bool',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function products()
    {
        return $this->belongsTo(Product::class);
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new PasswordResetNotification($token));
    }
    
    protected static function newFactory()
    {
        return \Modules\Admin\Database\factories\AdminFactory::new();
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function($model) {
            $model->attributes['password'] = $model->password ? \Hash::make($model->password) : \Hash::make('password');
            $model->attributes['active'] = $model->active ?? 1;
        });
    }
}
