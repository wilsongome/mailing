<?php
namespace App\Domain\Whatsapp\Chat;

use App\Domain\Contact\Contact;
use App\Domain\Whatsapp\Account\WpAccount;
use App\Domain\Whatsapp\Number\WpNumber;

class WpChat{

    public WpAccount $wpAccount;
    public WpNumber $wpNumber;
    public Contact $contact;
}
