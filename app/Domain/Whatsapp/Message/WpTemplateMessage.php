<?php
namespace App\Domain\Whatsapp\Message;

use App\Domain\Contact\Contact;
use App\Domain\Message\WpMessageInterface;
use App\Domain\Whatsapp\Account\WpAccount;
use App\Domain\Whatsapp\Number\WpNumber;
use App\Domain\Whatsapp\Template\WpTemplate;

class WpTemplateMessage extends WpMessage implements WpMessageInterface{

    public WpTemplate $wpTemplate;

    public function __construct(
        WpAccount $wpAccount,
        WpNumber $wpNumber,
        Contact $contact,
        WpTemplate $wpTemplate)
    {
        $this->wpAccount = $wpAccount;
        $this->wpNumber = $wpNumber;
        $this->wpTemplate = $wpTemplate;
        $this->contact = $contact;
    }
    
}
