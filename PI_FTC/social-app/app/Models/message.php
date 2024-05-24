<?php

namespace App\Models;

use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class message extends Model
{
    use HasFactory, InteractsWithSockets;

    protected $table = 'messages';

    // Relación con la tabla 'users'
    public function sender() {
        return $this->belongsTo('App\Models\User', 'sender_id', 'id');
    }

    public function receiver() {
        return $this->belongsTo('App\Models\User', 'receiver_id', 'id');
    }

    public function broadcastOn()
    {
        return new PrivateChannel('chat.' . $this->receiver_id);
    }
}
