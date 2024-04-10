<?php
namespace App\Domain\Message;

interface WpMessageInterface{

    public function save() : int;

    public function update() : bool;
}
