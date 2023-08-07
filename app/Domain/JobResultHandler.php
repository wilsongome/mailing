<?php
namespace App\Domain;

use App\Domain\Message\EmailMessageResultHandler;
use Exception;

class JobResultHandler{

    private array $jobResult = [];
    
    public function __construct(array $jobResult)
    {
        $this->jobResult = $jobResult;
    }

    public function execute(): void
    {
        if($this->jobResult['job'] == 'App\Mail\CampaignEmailMessage'){
            $emailMessageResultHandler = new EmailMessageResultHandler($this->jobResult['data']);
            $emailMessageResultHandler->execute();
        }
    }

}