<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CategoryChange implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $category;

    public function __construct($category)
    {
        $this->category = $category;
    }

    public function broadcastOn()
    {
        return new Channel('categories');
    }

    public function broadcastAs() {
        return 'categoryChange';
    }
}
