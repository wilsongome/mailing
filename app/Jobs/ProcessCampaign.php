<?php

namespace App\Jobs;

use App\Domain\Campaign\CampaignHandler;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessCampaign implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public int $campaignId)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $campaignHandler = new CampaignHandler($this->campaignId);
        $campaignHandler->execute();
    }
}
