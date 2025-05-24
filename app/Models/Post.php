<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable=[
        'title',
        'content',
        'status',
        'image_url',
        'scheduled_time',
        'user_id',
    ];
    protected $casts = [
    'scheduled_time' => 'datetime',
];

    public function platforms()
    {
        return $this->belongsToMany(Platform::class, 'post_platform')
            ->withPivot('platform_status')->withTimestamps();
    }
}
