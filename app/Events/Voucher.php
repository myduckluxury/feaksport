<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Voucher implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $voucher;

    public function __construct($voucher)
    {
        $this->voucher = $voucher;
        $this->dontBroadcastToCurrentUser();
    }
    
    public function broadcastOn(): array
    {
        return [
            new Channel('voucherChange'),
        ];
    }
    
    public function broadcastAs()
    {
        return 'voucher';
    }
}
