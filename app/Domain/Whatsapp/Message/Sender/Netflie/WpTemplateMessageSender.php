<?php
namespace App\Domain\Whatsapp\Message\Sender\Netflie;

use App\Domain\Whatsapp\Message\Response\WpMessageResponse;
use App\Domain\Whatsapp\Message\Sender\WpSender;
use App\Domain\Whatsapp\Message\WpTemplateMessage;
use Netflie\WhatsAppCloudApi\Response;
use Netflie\WhatsAppCloudApi\WhatsAppCloudApi;

class WpTemplateMessageSender extends Response implements WpSender{

    private WpTemplateMessage $wpTemplateMessage;

    public function __construct(WpTemplateMessage $wpTemplateMessage)
    {
        $this->wpTemplateMessage = $wpTemplateMessage;
    }

    public function send() : WpMessageResponse
    {
        $wpCloudApi = new WhatsAppCloudApi([
            'from_phone_number_id' => $this->wpTemplateMessage->wpNumber->externalId,
            'access_token' => $this->wpTemplateMessage->wpAccount->token
        ]);

        $response = $wpCloudApi->sendTemplate(
            $this->wpTemplateMessage->contact->whatsappNumber,
            $this->wpTemplateMessage->wpTemplate->name,
            $this->wpTemplateMessage->wpTemplate->language
        );

        return new WpMessageResponse(
            $response->http_status_code,
            $response->decoded_body['messages'][0]['id'],
            $response->decoded_body['messages'][0]['message_status'],
            $response->body
        );

    }
}
