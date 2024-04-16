<?php
namespace app\Domain\Whatsapp\Document;

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

    public static function isSupoorted(string $type, int $size) : bool
    {
        //Criar um switch pra verificar tanto o tamanho quanto o size, sendo o default retornar falso

        return true;
    }
}