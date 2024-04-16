<?php
namespace App\Domain\Whatsapp\Document\Uploader\Netflie;

use App\Domain\Whatsapp\Account\WpAccount;
use App\Domain\Whatsapp\Number\WpNumber;
use App\Domain\Whatsapp\Document\WpDocument;
use Illuminate\Support\Facades\Storage;
use Netflie\WhatsAppCloudApi\Response\ResponseException;
use Netflie\WhatsAppCloudApi\WhatsAppCloudApi;

class WpDocumentUploader{

    private WpAccount $wpAccount;
    private WpNumber $wpNumber;
    private WpDocument $wpDocument;

    public function __construct(
        WpAccount $wpAccount,
        WpNumber $wpNumber,
        WpDocument $wpDocument)
    {
        $this->wpAccount = $wpAccount;
        $this->wpNumber = $wpNumber;
        $this->wpDocument = $wpDocument;
    }

    public function upload() : string
    {
        try{
            $wpCloudApi = new WhatsAppCloudApi([
                'from_phone_number_id' => $this->wpNumber->externalId,
                'access_token' => $this->wpAccount->token
            ]);
    
            $response = $wpCloudApi->uploadMedia(Storage::path($this->wpDocument->localFilePath));
    
            return $response->decodedBody()['id'];
        }catch(ResponseException $e){
            print_r($e->response());
            return "";
        }
        
    }

}
