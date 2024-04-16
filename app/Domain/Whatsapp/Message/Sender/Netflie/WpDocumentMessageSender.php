<?php
namespace App\Domain\Whatsapp\Message\Sender\Netflie;

use App\Domain\Contact\Contact;
use App\Domain\Whatsapp\Account\WpAccount;
use App\Domain\Whatsapp\Document\Uploader\Netflie\WpDocumentUploader;
use App\Domain\Whatsapp\Message\Response\WpMessageResponse;
use App\Domain\Whatsapp\Message\Sender\WpSenderInterface;
use App\Domain\Whatsapp\Message\WpDocumentMessage;
use App\Domain\Whatsapp\Number\WpNumber;
use Exception;
use Netflie\WhatsAppCloudApi\Message\Media\MediaObjectID;
use Netflie\WhatsAppCloudApi\Response\ResponseException;
use Netflie\WhatsAppCloudApi\WhatsAppCloudApi;
use stdClass;

class WpDocumentMessageSender implements WpSenderInterface{

    private WpAccount $wpAccount;
    private WpNumber $wpNumber;
    private Contact $contact;
    private WpDocumentMessage $wpDocumentMessage;

    public function __construct(
        WpAccount $wpAccount,
        WpNumber $wpNumber,
        Contact $contact,
        WpDocumentMessage $wpDocumentMessage)
    {
        $this->wpAccount = $wpAccount;
        $this->wpNumber = $wpNumber;
        $this->contact = $contact;
        $this->wpDocumentMessage = $wpDocumentMessage;
    }

    private function getMediaId() : stdClass
    {
        $media = new stdClass();

        if(isset($this->wpDocumentMessage->wpDocument->link)){
            $media->id = $this->wpDocumentMessage->wpDocument->link;
            $media->type = "link";
            return $media;
        }

        if(isset($this->wpDocumentMessage->wpDocument->externalId)){
           $media->id = $this->wpDocumentMessage->wpDocument->externalId;
           $media->type = "id";
           return $media;
        }

        if(
            isset($this->wpDocumentMessage->wpDocument->id)
            &&
            !isset($this->wpDocumentMessage->wpDocument->externalId)
            &&
            isset($this->wpDocumentMessage->wpDocument->localFilePath)
            )
        {
            $uploader = new WpDocumentUploader(
                $this->wpAccount,
                $this->wpNumber,
                $this->wpDocumentMessage->wpDocument
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
            $response = $wpCloudApi->sendDocument(
                $this->contact->whatsappNumber,
                $mediaObjectId,
                $this->wpDocumentMessage->wpDocument->localFileName,
                $this->wpDocumentMessage->body
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
