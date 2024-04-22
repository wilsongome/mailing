<?php
namespace App\Domain\Whatsapp\Message\Sender\Netflie;

use App\Domain\Contact\Contact;
use App\Domain\Whatsapp\Account\WpAccount;
use App\Domain\Whatsapp\Media\Uploader\Netflie\WpMediaUploader;
use App\Domain\Whatsapp\Message\Response\WpMessageResponse;
use App\Domain\Whatsapp\Message\Sender\WpSenderInterface;
use App\Domain\Whatsapp\Message\WpImageMessage;
use App\Domain\Whatsapp\Number\WpNumber;
use Netflie\WhatsAppCloudApi\Message\Media\MediaObjectID;
use Netflie\WhatsAppCloudApi\Response\ResponseException;
use Netflie\WhatsAppCloudApi\WhatsAppCloudApi;
use stdClass;

class WpImageMessageSender implements WpSenderInterface{

    private WpAccount $wpAccount;
    private WpNumber $wpNumber;
    private Contact $contact;
    private WpImageMessage $wpImageMessage;

    public function __construct(
        WpAccount $wpAccount,
        WpNumber $wpNumber,
        Contact $contact,
        WpImageMessage $wpImageMessage)
    {
        $this->wpAccount = $wpAccount;
        $this->wpNumber = $wpNumber;
        $this->contact = $contact;
        $this->wpImageMessage = $wpImageMessage;
    }

    private function getMediaId() : stdClass
    {
        $media = new stdClass();

        if(isset($this->wpImageMessage->wpMedia->link)){
            $media->id = $this->wpImageMessage->wpMedia->link;
            $media->type = "link";
            return $media;
        }

        if(isset($this->wpImageMessage->wpMedia->externalId)){
           $media->id = $this->wpImageMessage->wpMedia->externalId;
           $media->type = "id";
           return $media;
        }

        if(
            isset($this->wpImageMessage->wpMedia->id)
            &&
            !isset($this->wpImageMessage->wpMedia->externalId)
            &&
            isset($this->wpImageMessage->wpMedia->localFilePath)
            )
        {
            $uploader = new WpMediaUploader(
                $this->wpAccount,
                $this->wpNumber,
                $this->wpImageMessage->wpMedia
            );

            $media->id = $uploader->upload();
            $media->type = "id";
            return $media;

        }
        
    }

    public function send() : WpMessageResponse
    {
        $wpCloudApi = new WhatsAppCloudApi([
            'from_phone_number_id' => $this->wpNumber->externalId,
            'access_token' => $this->wpAccount->token
        ]);

        $media = $this->getMediaId();
        $mediaObjectId = new MediaObjectID($media->id);
        $mediaObjectId->type($media->type);

        try{
            $response = $wpCloudApi->sendImage(
                $this->contact->whatsappNumber,
                $mediaObjectId,
                $this->wpImageMessage->body
            );
        }catch(ResponseException $e){
            $httpStatusCode = $e->response()->httpStatusCode();
            $message = $e->response()->decodedBody()["error"]["message"];
            return new WpMessageResponse($httpStatusCode, "", "error", $message);
        }
        
        return new WpMessageResponse(
            $response->httpStatusCode(),
            $response->decodedBody()['messages'][0]['id'],
            'accepted',
            $response->body()
        );

    }
}
