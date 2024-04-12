<?php

namespace App\Jobs;

use App\Domain\Whatsapp\Message\Sender\WpSenderInterface;
use App\Domain\Whatsapp\Message\WpMessageInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class WpMessageSenderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public WpMessageInterface $message, public WpSenderInterface $sender)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $response = $this->sender->send();
        $statusHistory = json_decode($this->message->messageStatusHistory, true);
        $statusHistory[date("Y-m-d H:i:s")] = $response->messageStatus();

        $this->message->wpExternalId = $response->id();
        $this->message->messageStatus = $response->messageStatus();
        $this->message->messageStatusHistory = json_encode($statusHistory);

        $this->message->update();

    }
}
