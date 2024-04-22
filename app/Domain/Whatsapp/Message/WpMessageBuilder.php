<?php
namespace App\Domain\Whatsapp\Message;

use App\Domain\Whatsapp\Chat\WpChat;
use App\Domain\Whatsapp\Media\WpMedia;
use App\Domain\Whatsapp\Template\WpMessageTemplate;
use DateTime;
use InvalidArgumentException;

class WpMessageBuilder{

    private WpChat $wpChat;

    public function __construct(WpChat $wpChat)
    {
        $this->wpChat = $wpChat;
    }

    public function buildTextMessage(string $textMessage) : WpTextMessage
    {
        try{

            $wpTextMessage = new WpTextMessage(
                $this->wpChat->wpAccountId,
                $this->wpChat->wpNumberId,
                $this->wpChat->wpAccountId,
                $this->wpChat->id,
                $textMessage
            );

            $wpTextMessage->body = $textMessage;
            $wpTextMessage->sendTime = new DateTime();
            $wpTextMessage->direction = "OUT";
            $wpTextMessage->user = "Frow";
            return $wpTextMessage;

        }catch(InvalidArgumentException $e){
            echo $e->getMessage();
        }
    }

    public function buildTemplateMessage(WpMessageTemplate $wpMessageTemplate)
    {
        try{

            $wpTemplateMessage = new WpTemplateMessage
            (
                $this->wpChat->wpAccountId,
                $this->wpChat->wpNumberId,
                $this->wpChat->wpAccountId,
                $this->wpChat->id,
                $wpMessageTemplate
            );

            $wpTemplateMessage->body = $wpMessageTemplate->template;
            $wpTemplateMessage->sendTime = new DateTime();
            $wpTemplateMessage->direction = "OUT";
            $wpTemplateMessage->user = "Frow";
            return $wpTemplateMessage;

        }catch(InvalidArgumentException $e){
            echo $e->getMessage();
        }
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

    public function buildImageMessage(WpMedia $wpMedia, string $textMessage = "") : WpImageMessage
    {
        try{

            $wpImageMessage = new WpImageMessage(
                $this->wpChat->wpAccountId,
                $this->wpChat->wpNumberId,
                $this->wpChat->wpAccountId,
                $this->wpChat->id,
                $wpMedia
            );
            $wpImageMessage->body = $textMessage;
            $wpImageMessage->sendTime = new DateTime();
            $wpImageMessage->direction = "OUT";
            $wpImageMessage->user = "Frow";

            return $wpImageMessage;

        }catch(InvalidArgumentException $e){
            echo $e->getMessage();
        }
    }

    public function buildVideoMessage(WpMedia $wpMedia, string $textMessage = "") : WpVideoMessage
    {
        try{

            $wpVideoMessage = new WpVideoMessage(
                $this->wpChat->wpAccountId,
                $this->wpChat->wpNumberId,
                $this->wpChat->wpAccountId,
                $this->wpChat->id,
                $wpMedia
            );

            $wpVideoMessage->body = $textMessage;
            $wpVideoMessage->sendTime = new DateTime();
            $wpVideoMessage->direction = "OUT";
            $wpVideoMessage->user = "Frow";

            return $wpVideoMessage;

        }catch(InvalidArgumentException $e){
            echo $e->getMessage();
        }
    }

    public function buildDocumentMessage(WpMedia $wpMedia, string $textMessage = "") : WpDocumentMessage
    {
        try{

            $wpDocumentMessage = new WpDocumentMessage(
                $this->wpChat->wpAccountId,
                $this->wpChat->wpNumberId,
                $this->wpChat->wpAccountId,
                $this->wpChat->id,
                $wpMedia
            );
            $wpDocumentMessage->body = $textMessage;
            $wpDocumentMessage->sendTime = new DateTime();
            $wpDocumentMessage->direction = "OUT";
            $wpDocumentMessage->user = "Frow";

            return $wpDocumentMessage;

        }catch(InvalidArgumentException $e){
            echo $e->getMessage();
        }
    }

}
