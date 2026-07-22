<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusHistory extends Model
{
    const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'reference_type',
        'reference_id',
        'from_status',
        'to_status',
        'comment_id',
    ];

    // Relationship to user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship to comment
    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }

    // Polymorphic relationship
    public function reference()
    {
        return $this->morphTo();
    }
}
