<?php

namespace Modules\Competition\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function competitions()
    {
        return $this->hasMany(Competition::class);
    }
    
    protected static function newFactory()
    {
        return \Modules\Competition\Database\factories\CategoryFactory::new();
    }
}
