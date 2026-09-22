<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OsisCandidate extends Model
{
    protected $fillable = [
        'candidate_number',
        'leader_name',
        'vice_name',
        'leader_class',
        'vice_class',
        'vision',
        'mission',
        'photo_path',
        'vote_count',
    ];

    public function votes(): HasMany
    {
        return $this->hasMany(OsisVote::class, 'candidate_id');
    }
}
