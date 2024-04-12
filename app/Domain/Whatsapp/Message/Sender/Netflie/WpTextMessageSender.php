<?php
namespace App\Domain\Whatsapp\Message\Sender\Netflie;

use App\Domain\Contact\Contact;
use App\Domain\Whatsapp\Account\WpAccount;
use App\Domain\Whatsapp\Message\Response\WpMessageResponse;
use App\Domain\Whatsapp\Message\Sender\WpSenderInterface;
use App\Domain\Whatsapp\Message\WpTemplateMessage;
use App\Domain\Whatsapp\Message\WpTextMessage;
use App\Domain\Whatsapp\Number\WpNumber;
use Exception;
use Netflie\WhatsAppCloudApi\WhatsAppCloudApi;

class WpTextMessageSender implements WpSenderInterface{

    private WpAccount $wpAccount;
    private WpNumber $wpNumber;
    private Contact $contact;
    private WpTextMessage $wpTextMessage;

    public function __construct(
        WpAccount $wpAccount,
        WpNumber $wpNumber,
        Contact $contact,
        WpTextMessage $wpTextMessage)
    {
        $this->wpAccount = $wpAccount;
        $this->wpNumber = $wpNumber;
        $this->contact = $contact;
        $this->wpTextMessage = $wpTextMessage;
    }

    public function send() : WpMessageResponse
    {
        $wpCloudApi = new WhatsAppCloudApi([
            'from_phone_number_id' => $this->wpNumber->externalId,
            'access_token' => $this->wpAccount->token
        ]);

        try{
            $response = $wpCloudApi->sendTextMessage(
                $this->contact->whatsappNumber,
                $this->wpTextMessage->body
            );
        }catch(Exception $e){
            $httpStatusCode = $e->response()->httpStatusCode();
            $message = $e->response()->decodedBody()["error"]["message"];
            return new WpMessageResponse($httpStatusCode, "", "error", $message);
        }
        

        return new WpMessageResponse(
            $response->httpStatusCode(),
            $response->decodedBody()['messages'][0]['id'],
            'ACCEPTED',
            $response->body()
        );

    }
}
