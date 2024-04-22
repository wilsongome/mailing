<?php
namespace App\Domain\Whatsapp\Message\Sender\Netflie;

use App\Domain\Contact\Contact;
use App\Domain\Whatsapp\Account\WpAccount;
use App\Domain\Whatsapp\Media\Uploader\Netflie\WpMediaUploader;
use App\Domain\Whatsapp\Message\Response\WpMessageResponse;
use App\Domain\Whatsapp\Message\Sender\WpSenderInterface;
use App\Domain\Whatsapp\Message\WpAudioMessage;
use App\Domain\Whatsapp\Message\WpDocumentMessage;
use App\Domain\Whatsapp\Number\WpNumber;
use Exception;
use Netflie\WhatsAppCloudApi\Message\Media\MediaObjectID;
use Netflie\WhatsAppCloudApi\Response\ResponseException;
use Netflie\WhatsAppCloudApi\WhatsAppCloudApi;
use stdClass;

class WpAudioMessageSender implements WpSenderInterface{

    private WpAccount $wpAccount;
    private WpNumber $wpNumber;
    private Contact $contact;
    private WpAudioMessage $wpAudioMessage;

    public function __construct(
        WpAccount $wpAccount,
        WpNumber $wpNumber,
        Contact $contact,
        WpAudioMessage $wpAudioMessage)
    {
        $this->wpAccount = $wpAccount;
        $this->wpNumber = $wpNumber;
        $this->contact = $contact;
        $this->wpAudioMessage = $wpAudioMessage;
    }

    private function getMediaId() : stdClass
    {
        $media = new stdClass();

        if(isset($this->wpAudioMessage->wpMedia->link)){
            $media->id = $this->wpAudioMessage->wpMedia->link;
            $media->type = "link";
            return $media;
        }

        if(isset($this->wpAudioMessage->wpMedia->externalId)){
           $media->id = $this->wpAudioMessage->wpMedia->externalId;
           $media->type = "id";
           return $media;
        }

        if(
            isset($this->wpAudioMessage->wpMedia->id)
            &&
            !isset($this->wpAudioMessage->wpMedia->externalId)
            &&
            isset($this->wpAudioMessage->wpMedia->localFilePath)
            )
        {
            $uploader = new WpMediaUploader(
                $this->wpAccount,
                $this->wpNumber,
                $this->wpAudioMessage->wpMedia
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
            $response = $wpCloudApi->sendAudio(
                $this->contact->whatsappNumber,
                $mediaObjectId
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
