<?php
namespace App\Domain\Message;

class EmailMessage{

    private array $data;
    public string $subject;
    public string $body;
    public string $to;

    public function __construct(array $data, string $body, string $subject, string $to)
    {
        $this->data = $data;
        $this->body = (string) $body;
        $this->subject = (string) $subject;
        $this->to = (string) $to;
    }

    public function message(): EmailMessage
    {
        return $this;
    }
}
