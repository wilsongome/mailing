<?php
namespace App\Domain\Whatsapp\Message;

use App\Domain\Contact\Contact;
use App\Domain\Whatsapp\Account\WpAccount;
use App\Domain\Whatsapp\Number\WpNumber;

abstract class WpMessage{

    public string $wpMessageId;
    public WpAccount $wpAccount;
    public WPNumber $wpNumber;
    public Contact $contact;

    public function __construct(WpAccount $wpAccount, WpNumber $wpNumber, Contact $contact)
    {
        $this->wpAccount = $wpAccount;
        $this->wpNumber = $wpNumber;
        $this->contact = $contact;
    }

}
