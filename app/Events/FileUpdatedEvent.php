<?php

namespace App\Events;

use App\Models\File;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FileUpdatedEvent implements ShouldBroadcastNow {
	use Dispatchable, InteractsWithSockets, SerializesModels;

	protected $userId;
	protected $file;

	public function __construct(int $userId, File $file) {
		$this->userId = $userId;
		$this->file = $file;
	}

	public function broadcastOn() {
		return new PrivateChannel("lw.$this->userId");
	}

	public function broadcastAs(): string {
		return 'file-updated-event';
	}
}
