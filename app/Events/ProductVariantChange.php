<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProductVariantChange implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $productId;
    public $productVariant;
    public function __construct($productId, $productVariant)
    {
        $this->productId = $productId;
        $this->productVariant = $productVariant;
        $this->dontBroadcastToCurrentUser();
    }

    public function broadcastOn()
    {
        return new Channel('productVariants.' . $this->productId);
    }

    public function broadcastAs() {
        return 'productVariant';
    }
}
