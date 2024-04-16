<?php
namespace App\Domain\Whatsapp\Message\Sender\Netflie;

use App\Domain\Contact\Contact;
use App\Domain\Whatsapp\Account\WpAccount;
use App\Domain\Whatsapp\Message\Response\WpMessageResponse;
use App\Domain\Whatsapp\Message\Sender\WpSenderInterface;
use App\Domain\Whatsapp\Message\WpTemplateMessage;
use App\Domain\Whatsapp\Number\WpNumber;
use Exception;
use Netflie\WhatsAppCloudApi\Response;
use Netflie\WhatsAppCloudApi\Response\ResponseException;
use Netflie\WhatsAppCloudApi\WhatsAppCloudApi;

class WpTemplateMessageSender implements WpSenderInterface{

    private WpAccount $wpAccount;
    private WpNumber $wpNumber;
    private Contact $contact;
    private WpTemplateMessage $wpTemplateMessage;

    public function __construct(
        WpAccount $wpAccount,
        WpNumber $wpNumber,
        Contact $contact,
        WpTemplateMessage $wpTemplateMessage)
    {
        $this->wpAccount = $wpAccount;
        $this->wpNumber = $wpNumber;
        $this->contact = $contact;
        $this->wpTemplateMessage = $wpTemplateMessage;
    }

    public function send() : WpMessageResponse
    {
        $wpCloudApi = new WhatsAppCloudApi([
            'from_phone_number_id' => $this->wpNumber->externalId,
            'access_token' => $this->wpAccount->token
        ]);

        try{
            $response = $wpCloudApi->sendTemplate(
                $this->contact->whatsappNumber,
                $this->wpTemplateMessage->wpTemplate->name,
                $this->wpTemplateMessage->wpTemplate->language
            );
        }catch(ResponseException $e){
            $httpStatusCode = $e->response()->httpStatusCode();
            $message = $e->response()->decodedBody()["error"]["message"];
            return new WpMessageResponse($httpStatusCode, "", "error", $message);
        }
        

        return new WpMessageResponse(
            $response->httpStatusCode(),
            $response->decodedBody()['messages'][0]['id'],
            $response->decodedBody()['messages'][0]['message_status'],
            $response->body()
        );

    }
}
