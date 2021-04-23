<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PlayersPointsEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $players;
    public $winner;
    public $winner_answer;
    public $rounds_left;
    private $quiz_code;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($quiz_code,$players,$winner,$winner_answer,$rounds_left)
    {
        $this->quiz_code = $quiz_code;
        $this->players = $players;
        $this->winner = $winner;
        $this->winner_answer = $winner_answer;
        $this->rounds_left = $rounds_left;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PresenceChannel('quiz.'.$this->quiz_code);
    }
}
