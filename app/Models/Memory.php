<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Memory extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'media_path',
        'media_type',
        'is_favorite'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
