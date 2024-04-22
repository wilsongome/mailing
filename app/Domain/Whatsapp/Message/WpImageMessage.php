<?php
namespace App\Domain\Whatsapp\Message;

use App\Domain\Whatsapp\Media\WpMedia;
use Exception;
use InvalidArgumentException;

class WpImageMessage extends WpMessage implements WpMessageInterface{

    public string $localFilePath;
    public string $localFileName;
    public string $fileType;
    public string $externalFileId;
    public WpMedia $wpMedia;

    public function __construct(
        int $wpAccountId,
        int $wpNumberId,
        int $contactId,
        int $wpChatId,
        WpMedia $wpMedia)
    {
        $this->wpAccountId = $wpAccountId;
        $this->wpNumberId = $wpNumberId;
        $this->contactId = $contactId;
        $this->wpChatId = $wpChatId;
        $this->wpMedia = $wpMedia;
        $this->type = "IMAGE";
      
    }

    public function store() : int
    {
        try{
            $wpMessageModel = $this->getModel();
            $wpMessageModel->wp_media_id = $this->wpMedia->id;
            
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
