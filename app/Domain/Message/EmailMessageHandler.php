<?php
namespace App\Domain\Message;

use App\Mail\CampaignEmailMessage;
use Exception;
use Illuminate\Support\Facades\Mail;
use App\Domain\Message\EmailMessage;

class EmailMessageHandler{

    public EmailMessage $emailMessage;

    public function __construct(EmailMessage $emailMessage)
    {
        $this->emailMessage = $emailMessage;
    }

    private function validateMainValues(EmailMessage $emailMessage)
    {
       if(!$emailMessage->to || !$emailMessage->subject){
            return false;
       }
       return true;
    }

    public function queueMessage(int $contactListId, int $registers, int $messagePosition): array
    {
        try {
            $result = ['status' => false];
            if(!$this->validateMainValues($this->emailMessage)){
                $result['error'] = 'Missing main values to message!';
                return $result;
            }
            
            Mail::to($this->emailMessage->to)
            ->send(new CampaignEmailMessage(
                $this->emailMessage,
                $contactListId,
                $registers,
                $messagePosition));
                
            $result = ['status' => true];
            
        } catch (Exception $e) {
            $result = ['status' => false, 'error' => $e->getMessage()];
        }
        return $result;
    }
}
