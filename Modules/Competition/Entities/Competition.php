<?php

namespace Modules\Competition\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Competition extends Model
{
    use HasFactory;

    // protected $table = 'competitions';
    protected $fillable = [
        'name',
    'short_description',
    'description',
    'start_at',
    'end_at',
    'category_id',
    'max_team_number',
    'award',
    'image',
    
    ];

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    
    protected static function newFactory()
    {
        return \Modules\Competition\Database\factories\CompetitionFactory::new();
    }
}
