<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role',
        'name',
        'surname',
        'nick',
        'profileDescription',
        'genero',
        'telefono',
        'email',
        'password',
        'image',
        'remember_token',
        'edad',
        'residencia',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function images(){
        return $this->hasMany('App\Models\Image');
    }

    public function likeMatches()
    {
        return $this->hasMany(LikeMatch::class);
    }

    // public function matches()
    // {
    //     return $this->hasMany(UserMatch::class, 'user1_id')->orWhere('user2_id', $this->id);
    // }

    public function matchesAsUser1()
    {
    return $this->hasMany(UserMatch::class, 'user1_id');
    }

    public function matchesAsUser2()
    {
    return $this->hasMany(UserMatch::class, 'user2_id');
    }

    public function getMatchesAttribute()
    {
    return $this->matchesAsUser1->concat($this->matchesAsUser2);
    }

    public function userMatches()
    {
        return $this->hasMany(UserMatch::class, 'user1_id')->orWhere('user2_id', $this->id);
    }


    public function blockedUsers()
    {
        return $this->hasMany(UserBlock::class, 'blocker_id');
    }

    public function blockingUsers()
    {
        return $this->hasMany(UserBlock::class, 'blocked_id');
    }

    public function messageableUsers()
    {
        $blockedUserIds = $this->blockedUsers->pluck('blocked_id');
        $blockingUserIds = $this->blockingUsers->pluck('blocker_id');

        return User::whereNotIn('id', $blockedUserIds)
                    ->whereNotIn('id', $blockingUserIds)
                    ->get();
    }
    

    // Relación con la tabla 'messages'
    public function sentMessages() {
        return $this->hasMany('App\Models\Message', 'sender_id', 'id');
    }

    public function receivedMessages() {
        return $this->hasMany('App\Models\Message', 'receiver_id', 'id');
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
