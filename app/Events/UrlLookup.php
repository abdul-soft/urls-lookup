<?php

namespace App\Events;

use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UrlLookup implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $user;
    protected $title;
    protected $order;

    /**
     * Create a new event instance.
     *
     * @param User $user
     * @param string $title
     * @param integer $order
     * @return void
     */
    public function __construct(User $user, $title, $order)
    {
        $this->user = $user;
        $this->title = $title;
        $this->order = $order;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('url-lookup');
    }

    public function broadcastWith()
    {
        \Log::info($this->title);
        return ['title' =>  $this->title, 'order'   =>  $this->order];
    }
}
