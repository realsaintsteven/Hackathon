<?php

namespace Modules\Competition\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Submission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'team_id',
        'description',
        'intership_open',
        'submitted_at',
        'url',
        'repo_url',
        'document',
        //'image',
    ];
    
    public function teams()
    {
        return $this->belongTo(Team::class);
    }

    protected static function newFactory()
    {
        return \Modules\Competition\Database\factories\SubmissionFactory::new();
    }
}
