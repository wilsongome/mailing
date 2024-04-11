<?php
namespace App\Domain\Whatsapp\Chat;
use DateTime;

class WpChat{

    public int $id;
    public int $wpAccountId;
    public int $wpNumberId;
    public int $contactId;
    public DateTime $firstContactMessage;
    public DateTime $lastContactMessage;
    public WpChatStatus $status;
    public string $createdBy;

    public function setStatusByString(string $status) : void
    {
        if($status == WpChatStatus::OPEN->name){
            $this->status = WpChatStatus::OPEN;
        }

        if($status == WpChatStatus::CLOSED->name){
            $this->status = WpChatStatus::CLOSED;
        }

        if($status == WpChatStatus::FINISHED->name){
            $this->status = WpChatStatus::FINISHED;
        }
    }

    public function getMinutesToChatClosing() : int
    {
        $minutesToCloseReference = 1440; //24Hours

        if(!$this->firstContactMessage || !$this->lastContactMessage || $this->status == WpChatStatus::FINISHED){
            return 0;
        }
        $currentDateTime = new DateTime();
        $interval = $this->lastContactMessage->diff($currentDateTime);
        $partialMinutes = (int) $interval->format("%i");
        $fullHours = (int) $interval->format("%h");

        $minutesSinceLastContact = ($fullHours * 60) + $partialMinutes;
        
        $minutesToClose = $minutesToCloseReference - $minutesSinceLastContact;

        if($minutesToClose <= 0){
            $minutesToClose = 0;
        }

        if($minutesToClose >= $minutesToCloseReference){
            $minutesToClose = $minutesToCloseReference;
        }

        return $minutesToClose;
    }
    
}
