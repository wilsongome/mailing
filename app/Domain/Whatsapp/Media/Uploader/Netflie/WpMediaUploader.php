<?php
namespace App\Domain\Whatsapp\Media\Uploader\Netflie;

use App\Domain\Whatsapp\Account\WpAccount;
use App\Domain\Whatsapp\Number\WpNumber;
use App\Domain\Whatsapp\Media\WpMedia;
use Illuminate\Support\Facades\Storage;
use Netflie\WhatsAppCloudApi\Response\ResponseException;
use Netflie\WhatsAppCloudApi\WhatsAppCloudApi;

class WpMediaUploader{

    private WpAccount $wpAccount;
    private WpNumber $wpNumber;
    private WpMedia $wpMedia;

    public function __construct(
        WpAccount $wpAccount,
        WpNumber $wpNumber,
        WpMedia $wpMedia)
    {
        $this->wpAccount = $wpAccount;
        $this->wpNumber = $wpNumber;
        $this->wpMedia = $wpMedia;
    }

    public function upload() : string
    {
        try{
            $wpCloudApi = new WhatsAppCloudApi([
                'from_phone_number_id' => $this->wpNumber->externalId,
                'access_token' => $this->wpAccount->token
            ]);
    
            $response = $wpCloudApi->uploadMedia(Storage::path($this->wpMedia->localFilePath));
    
            return $response->decodedBody()['id'];
        }catch(ResponseException $e){
            print_r($e->response());
            return "";
        }
        
    }

}
