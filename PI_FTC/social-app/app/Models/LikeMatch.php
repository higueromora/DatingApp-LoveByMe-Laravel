<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LikeMatch extends Model
{
    use HasFactory;

    protected $table = 'likematch';

    protected $fillable = [
        'user_id',
        'target_user_id',
        'click_type'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
