<?php
namespace App\Domain\Campaign;

class CampaignEmailMessageHandler{

    private array $data_header;
    private array $data;
    public string $subject;
    public string $body;

    public function __construct(array $data, string $body, string $subject)
    {
        $this->data = $data;
        $this->body = $body;
        $this->subject = $subject;
    }

    public function message(): CampaignEmailMessageHandler
    {
        return $this;
    }
}
?>