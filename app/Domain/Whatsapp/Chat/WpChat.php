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
    public string $status;
    public string $createdBy;
    
}
