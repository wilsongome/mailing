<?php
namespace App\Domain\Whatsapp\Document;

use App\Domain\Whatsapp\Media\WpMediaType;
use stdClass;

class SupportedMediaTypes{
    /**
     * Size in Kb
     */

    private $audio = [
        'maxSize' => 16384,
        'types'=> [
            'audio/aac',
            'audio/mp4',
            'audio/mpeg',
            'audio/amr',
            'audio/ogg'
        ]
    ];

    private $document = [
        'maxSize' => 102400,
        'types'=> [
            'text/plain',
            'application/pdf',
            'application/vnd.ms-powerpoint',
            'application/msword',
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        ]
    ];

    private $image = [
        'maxSize' => 5120,
        'types'=> [
            'image/jpeg',
            'image/png'
        ]
    ];

    private $video = [
        'maxSize' => 16384,
        'types'=> [
            'video/mp4',
            'video/3gp'
        ]
    ];

    private $sticker = [
        'maxSize' => 100,
        'types'=> [
            'image/webp'
        ]
    ];

    private function validateSize(int $maxSize, int $uploadedMediaSize) : bool
    {
        return $uploadedMediaSize <= $maxSize;
    }

    public function validate(string $type, int $size) : stdClass
    {
        $result = new stdClass();
        $result->type = "invalid";
        $result->mimeType = $type;
        $result->size = $size;
        $result->maxSize = 0;
        $result->validMimeType = false;
        $result->validSize = false;
        $result->isValid = false;

        if(in_array($type, $this->audio["types"])){
            $result->type = WpMediaType::AUDIO;
            $result->mimeType = $type;
            $result->size = $size;
            $result->maxSize = $this->audio["maxSize"];
            $result->validMimeType = true;
            $result->validSize = $this->validateSize($this->audio["maxSize"], $size);
            $result->isValid = $result->validSize;
        }

        if(in_array($type, $this->document["types"])){
            $result->type = WpMediaType::DOCUMENT;
            $result->mimeType = $type;
            $result->size = $size;
            $result->maxSize = $this->document["maxSize"];
            $result->validMimeType = true;
            $result->validSize = $this->validateSize($this->document["maxSize"], $size);
            $result->isValid = $result->validSize;
        }

        if(in_array($type, $this->image["types"])){
            $result->type = WpMediaType::IMAGE;
            $result->mimeType = $type;
            $result->size = $size;
            $result->maxSize = $this->image["maxSize"];
            $result->validMimeType = true;
            $result->validSize = $this->validateSize($this->image["maxSize"], $size);
            $result->isValid = $result->validSize;
        }

        if(in_array($type, $this->video["types"])){
            $result->type = WpMediaType::VIDEO;
            $result->mimeType = $type;
            $result->size = $size;
            $result->maxSize = $this->video["maxSize"];
            $result->validMimeType = true;
            $result->validSize = $this->validateSize($this->video["maxSize"], $size);
            $result->isValid = $result->validSize;
        }

        if(in_array($type, $this->sticker["types"])){
            $result->type = WpMediaType::STICKER;
            $result->mimeType = $type;
            $result->size = $size;
            $result->maxSize = $this->sticker["maxSize"];
            $result->validMimeType = true;
            $result->validSize = $this->validateSize($this->sticker["maxSize"], $size);
            $result->isValid = $result->validSize;
        }

        return $result;
    
    }
}