<?php
namespace App\Domain\Whatsapp\Chat;

use App\Domain\Whatsapp\Message\WpMessageInterface;

class WpChatMessage{

    public WpChat $wpChat;
    public WpMessageInterface $message;

    public function __construct(WpChat $wpChat, WpMessageInterface $message)
    {
        $this->wpChat = $wpChat;
        $this->message = $message;
    }

}
