<?php
namespace App\Domain\Message;

interface WpMessageInterface{

    public function store() : int;

    public function update() : bool;
}
