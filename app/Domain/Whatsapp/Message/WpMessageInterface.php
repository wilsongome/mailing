<?php
namespace App\Domain\Whatsapp\Message;

interface WpMessageInterface{

    public function store() : int;

    public function update() : bool;
}
