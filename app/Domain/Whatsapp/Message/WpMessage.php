<?php
namespace App\Domain\Whatsapp\Message;

use App\Domain\Contact\Contact;
use App\Domain\Whatsapp\Account\WpAccount;
use App\Domain\Whatsapp\Chat\WpChat;
use App\Domain\Whatsapp\Number\WpNumber;
use DateTime;

abstract class WpMessage{

    public int $id;
    public int $wpAccountId;
    public int $wpNumberId;
    public int $wpChatId;
    public int $contactId;
    public string $wpExternalId;
    public string $body;
    public string $messageStatus;
    public string $messageStatusHistory;
    public DateTime $sendTime;
    public string $direction;
    public string $user;
    public string $type;

    public function __construct(int $wpAccountId, int $wpNumberId, int $contactId, int $wpChatId)
    {
        $this->wpAccountId = $wpAccountId;
        $this->wpNumberId = $wpNumberId;
        $this->contactId = $contactId;
        $this->wpChatId = $wpChatId;
    }

}
