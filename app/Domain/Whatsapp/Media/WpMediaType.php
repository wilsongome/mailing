<?php
namespace App\Domain\Whatsapp\Media;

enum WpMediaType{

    case AUDIO;
    case DOCUMENT;
    case IMAGE;
    case VIDEO;
    case STICKER;

}
