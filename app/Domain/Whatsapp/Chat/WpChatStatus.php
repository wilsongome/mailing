<?php
namespace App\Domain\Whatsapp\Chat;

enum WpChatStatus{

    case OPEN;
    case CLOSED;
    case FINISHED;
    
}
