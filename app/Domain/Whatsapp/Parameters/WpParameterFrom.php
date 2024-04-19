<?php
namespace App\Domain\Whatsapp\Parameters;

enum WpParameterFrom{

    case TEMPLATE_HEADER;
    case TEMPLATE_BODY;
    case MESSAGE;
    
}
