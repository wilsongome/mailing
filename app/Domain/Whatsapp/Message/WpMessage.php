<?php
namespace App\Domain\Whatsapp\Message;

use App\Domain\Contact\Contact;
use App\Domain\Whatsapp\Account\WpAccount;
use App\Domain\Whatsapp\Number\WpNumber;
use DateTime;

abstract class WpMessage{

    public int $id;
    public string $wpMessageId;
    public string $messageStatus;
    public string $messageStatusHistory;
    public DateTime $sendTime;
    public string $direction;
    public WpAccount $wpAccount;
    public WPNumber $wpNumber;
    public Contact $contact;
    public string $body;

    public function __construct(WpAccount $wpAccount, WpNumber $wpNumber, Contact $contact)
    {
        $this->wpAccount = $wpAccount;
        $this->wpNumber = $wpNumber;
        $this->contact = $contact;
    }

}
