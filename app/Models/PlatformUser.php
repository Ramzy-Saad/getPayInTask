<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlatformUser extends Model
{
    protected $fillable = ['user_id', 'platform_id'];

    public function platform()
    {
        return $this->belongsTo(Platform::class);
    }
}
