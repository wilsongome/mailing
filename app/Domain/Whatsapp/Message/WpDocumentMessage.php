<?php
namespace App\Domain\Whatsapp\Message;

use app\Domain\Whatsapp\Document\WpDocument;
use Exception;
use InvalidArgumentException;

class WpDocumentMessage extends WpMessage implements WpMessageInterface{

    public string $localFilePath;
    public string $localFileName;
    public string $fileType;
    public string $externalFileId;
    public WpDocument $wpDocument;

    public function __construct(
        int $wpAccountId,
        int $wpNumberId,
        int $contactId,
        int $wpChatId,
        WpDocument $wpDocument)
    {
        $this->wpAccountId = $wpAccountId;
        $this->wpNumberId = $wpNumberId;
        $this->contactId = $contactId;
        $this->wpChatId = $wpChatId;
        $this->wpDocument = $wpDocument;
        $this->type = "document";
      
    }

    public function store() : int
    {
        try{
            $wpMessageModel = $this->getModel();
            $wpMessageModel->wp_document_id = $this->wpDocument->id;
            
            $wpMessageModel->save();

            return $wpMessageModel->id;

        }catch(Exception $e){
            echo $e->getMessage();
            return 0;
        }
        
    }

    public function update(): bool
    {
        try{
            $result = false;

            if(!isset($this->id)){
                throw new InvalidArgumentException("messageId is required");
            }

            $wpMessageModel = $this->getModel();
            $wpMessageModel->save();

            $result = true;

        }catch(InvalidArgumentException $e){
            echo $e->getMessage();
        }catch(Exception $e){
            echo $e->getMessage();
        }

        return $result;
    }

    
}
