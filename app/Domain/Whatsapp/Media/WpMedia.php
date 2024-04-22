<?php
namespace App\Domain\Whatsapp\Media;

use App\Domain\Whatsapp\Media\SupportedMediaTypes;
use App\Models\WpMedia as WpMediaModel;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use InvalidArgumentException;

class WpMedia{

    public int $id;
    public int $wpChatId;
    public string $localFilePath;
    public string $localFileName;
    public string $link;
    public string $externalId;
    public string $type;
    public WpMediaType $wpType;
    public string $size;
    public string $fileExtension;

    public function __construct(int $wpChatId, int $id)
    {
        $this->wpChatId = $wpChatId;

        if(isset($id) && $id > 0){
            $this->load($id);
        }
    }

    public function getWpMediaTypeByString(string $wpMediaType) : WpMediaType
    {
        $result = null;

        switch($wpMediaType){
            case WpMediaType::AUDIO->name:
                $result = WpMediaType::AUDIO;
                break;
            case WpMediaType::IMAGE->name:
                $result = WpMediaType::IMAGE;
                break;
            case WpMediaType::VIDEO->name:
                $result = WpMediaType::VIDEO;
                break;
            case WpMediaType::STICKER->name:
                $result = WpMediaType::STICKER;
                break;
            default:
                $result = WpMediaType::DOCUMENT;
        }

        return $result;
    }

    private function store() : void
    {
        $model = new WpMediaModel();
        $model->wp_chat_id = $this->wpChatId;
        $model->local_file_path = $this->localFilePath;
        $model->local_file_name = $this->localFileName;
        $model->link = isset($this->link) ?? null;
        $model->external_id = isset($this->externalId) ?? null;
        $model->type = $this->type;
        $model->wp_type = $this->wpType->name;
        $model->size = $this->size;
        $model->file_extension = $this->fileExtension;
        $model->save();

        $this->id = $model->id;
    }

    public function setExternalId(string $externalId) : bool
    {
        if(!$externalId || !$this->id){
            return false;
        }

        $this->externalId = $externalId;
        $model = WpMediaModel::find($this->id);
        $model->external_id = $this->externalId;
        $model->update();
        return true;
    }

    private function load(int $id)
    {
        $search = WpMediaModel::find($id);
        
        if($search->id){
            $this->id = $search->id;
            $this->wpChatId = $search->wp_chat_id;
            $this->localFilePath = $search->local_file_path;
            $this->localFileName = $search->local_file_name;
            $this->link = $search->link;
            $this->externalId = $search->external_id;
            $this->type = $search->type;
            $this->wpType = $this->getWpMediaTypeByString($search->wp_type);
            $this->size = $search->size;
            $this->fileExtension = $search->file_extension;
        }
    }

    public function upload(UploadedFile $file) : bool
    {
        try{
            $this->localFileName = $file->getClientOriginalName();
            $this->fileExtension = $file->getClientOriginalExtension();
            $this->type = $file->getClientMimeType();
            $this->size = round($file->getSize()/1024);

            $supportedMediaTypes = new SupportedMediaTypes();
            $validatedMedia = $supportedMediaTypes->validate($this->type, $this->size);
        
            if(!$validatedMedia->isValid){
                if(!$validatedMedia->validMimeType){
                    throw new InvalidArgumentException("Invalid file type!");
                }

                if(!$validatedMedia->validSize){
                    throw new InvalidArgumentException("Invalid file size!");
                }
            }

            $this->localFilePath = Storage::putFile('wp_medias/chat_'.$this->wpChatId, $file);
            $this->wpType = $validatedMedia->type;

            $this->store();
           
            return true;
        }catch(InvalidArgumentException $e){
            echo $e->getMessage();
            return false;
        }
    }

}


