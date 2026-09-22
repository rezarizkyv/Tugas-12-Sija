<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Module extends Model
{
    protected $fillable = [
        'course_id',
        'title',
        'description',
        'type',
        'content_url',
        'order_index',
        'is_published',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
