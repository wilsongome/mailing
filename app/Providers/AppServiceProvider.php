<?php

namespace App\Providers;

use App\Domain\JobResultHandler;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Queue::after(
            function (JobProcessed $event){
                $payload = $event->job->payload();
                $jobName = $payload['displayName'];
                $jobResult = ['job' => $jobName, 'data' => $payload['data']['command'] ];
                $emailResultHandler = new JobResultHandler($jobResult);
                $emailResultHandler->execute();
            }
        );
    }
}
