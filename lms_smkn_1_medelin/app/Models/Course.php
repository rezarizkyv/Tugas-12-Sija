<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    protected $fillable = [
        'major',
        'code',
        'title',
        'teacher',
        'modules_count',
        'assignments_count',
        'progress',
        'icon',
        'color',
    ];

    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class);
    }

    public function modules(): HasMany
    {
        return $this->hasMany(Module::class);
    }
}
