<?php

namespace Modules\Competition\Entities;
use Modules\User\Entities\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'remark',
        'user_id',
        'competition_id',
       
    ];
    
    // public function teamUser()
    // {
    //     return $this->belongsToMany(User::class, 'team_user')
    //     ->select('users.id', 'user_id');
    // }

    public function competitions()
    {
        return $this->hasMany(Competition::class);
    }

    public function submissions()
    {
        return $this->belongsTo(Submission::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class)
        ->withDefault();
    }
   
    public function users()
{
    return $this->belongsToMany(User::class)->withDefault();
}

    
    protected static function newFactory()
    {
        return \Modules\Competition\Database\factories\TeamFactory::new();
    }
}
