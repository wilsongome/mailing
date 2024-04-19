<?php
namespace App\Domain\Whatsapp\Document;

use App\Domain\Whatsapp\Document\SupportedMediaTypes;
use App\Models\WpDocument as WpDocumentModel;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use InvalidArgumentException;

class WpDocument{

    public int $id;
    public int $wpChaptId;
    public string $localFilePath;
    public string $localFileName;
    public string $link;
    public string $externalId;
    public string $type;
    public string $size;
    public string $fileExtension;

    public function __construct(int $wpChaptId, int $id)
    {
        $this->wpChaptId = $wpChaptId;

        if(isset($id) && $id > 0){
            $this->load($id);
        }
    }

    private function store() : void
    {
        $model = new WpDocumentModel();
        $model->wp_chat_id = $this->wpChaptId;
        $model->local_file_path = $this->localFilePath;
        $model->local_file_name = $this->localFileName;
        $model->link = isset($this->link) ?? null;
        $model->external_id = isset($this->externalId) ?? null;
        $model->type = $this->type;
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
        $model = WpDocumentModel::find($this->id);
        $model->external_id = $this->externalId;
        $model->update();
        return true;
    }

    private function load(int $id)
    {
        $search = WpDocumentModel::find($id);
        
        if($search->id){
            $this->id = $search->id;
            $this->wpChaptId = $search->wp_chat_id;
            $this->localFilePath = $search->local_file_path;
            $this->localFileName = $search->local_file_name;
            $this->link = $search->link;
            $this->externalId = $search->external_id;
            $this->type = $search->type;
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

            $this->localFilePath = Storage::putFile('wp_documents/chat_'.$this->wpChaptId, $file);

            $this->store();
           
            return true;
        }catch(InvalidArgumentException $e){
            echo $e->getMessage();
            return false;
        }
    }

}


