<?php
namespace App\Domain\Whatsapp\Message;

use App\Domain\Whatsapp\Chat\WpChat;
use App\Domain\Whatsapp\Media\WpMedia;
use DateTime;
use InvalidArgumentException;

class WpMessageBuilder{

    private WpChat $wpChat;

    public function __construct(WpChat $wpChat)
    {
        $this->wpChat = $wpChat;
    }

    public function buildAudioMessage(WpMedia $wpMedia) : WpAudioMessage
    {
        try{

            $wpAudioMessage = new WpAudioMessage(
                $this->wpChat->wpAccountId,
                $this->wpChat->wpNumberId,
                $this->wpChat->wpAccountId,
                $this->wpChat->id,
                $wpMedia
            );

            $wpAudioMessage->body = "";
            $wpAudioMessage->sendTime = new DateTime();
            $wpAudioMessage->direction = "OUT";
            $wpAudioMessage->user = "Frow";

            return $wpAudioMessage;

        }catch(InvalidArgumentException $e){
            echo $e->getMessage();
        }
    }

    public function buildImageMessage(WpMedia $wpMedia, string $textMessage) : WpImageMessage
    {
        try{

            $wpImageMessage = new WpImageMessage(
                $this->wpChat->wpAccountId,
                $this->wpChat->wpNumberId,
                $this->wpChat->wpAccountId,
                $this->wpChat->id,
                $wpMedia
            );
            $wpImageMessage->body = $textMessage ?? "";
            $wpImageMessage->sendTime = new DateTime();
            $wpImageMessage->direction = "OUT";
            $wpImageMessage->user = "Frow";

            return $wpImageMessage;

        }catch(InvalidArgumentException $e){
            echo $e->getMessage();
        }
    }

    public function buildDocumentMessage(WpMedia $wpMedia, string $textMessage) : WpDocumentMessage
    {
        try{

            $wpDocumentMessage = new WpDocumentMessage(
                $this->wpChat->wpAccountId,
                $this->wpChat->wpNumberId,
                $this->wpChat->wpAccountId,
                $this->wpChat->id,
                $wpMedia
            );
            $wpDocumentMessage->body = $textMessage ?? "";
            $wpDocumentMessage->sendTime = new DateTime();
            $wpDocumentMessage->direction = "OUT";
            $wpDocumentMessage->user = "Frow";

            return $wpDocumentMessage;

        }catch(InvalidArgumentException $e){
            echo $e->getMessage();
        }
    }

}
