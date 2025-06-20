<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProductChange implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $productId;
    public $product;

    public function __construct($productId, $product)
    {
        $this->productId = $productId;
        $this->product = $product;
        $this->dontBroadcastToCurrentUser();
    }
    public function broadcastOn():array
    {
        return [
            new Channel('products'),
            new Channel('product.' .$this->productId),
        ];
    }

    public function broadcastAs() {
        return 'productChange';
    }
}
