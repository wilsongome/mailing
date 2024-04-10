<?php
namespace App\Domain\Whatsapp\Message;

use App\Domain\Contact\Contact;
use App\Domain\Message\WpMessageInterface;
use App\Domain\Whatsapp\Account\WpAccount;
use App\Domain\Whatsapp\Number\WpNumber;

class WpMessageSampleText extends WpMessage implements WpMessageInterface{

    public function __construct(
        WpAccount $wpAccount,
        WpNumber $wpNumber,
        Contact $contact,
        string $body)
    {
        $this->wpAccount = $wpAccount;
        $this->wpNumber = $wpNumber;
        $this->contact = $contact;
        $this->body = $body;
    }
    

    public function save() : int
    {
        return 1;
    }

    public function update(): bool
    {
        return true;
    }
}
