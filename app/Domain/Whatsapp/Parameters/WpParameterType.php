<?php
namespace App\Domain\Whatsapp\Parameters;

enum WpParameterType{

    case STATIC;
    case DYNAMIC;
    case CONTACT_NAME;
    case CONTACT_EMAIL;
    case CONTACT_WHATSAPP_NUMBER;
    case CONTACT_TELEPHONE_NUMBER;
    
}
