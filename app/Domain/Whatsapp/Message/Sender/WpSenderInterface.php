<?php
namespace App\Domain\Whatsapp\Message\Sender;

use App\Domain\Whatsapp\Message\Response\WpMessageResponse;

interface WpSenderInterface{

    public function send() : WpMessageResponse;

}
