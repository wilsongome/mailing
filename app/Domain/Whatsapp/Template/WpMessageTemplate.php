<?php
namespace App\Domain\Whatsapp\Template;

class WpMessageTemplate{
    public int $id;
    public int $accountId;
    public string $externalId;
    public string $name;
    public string $template;
    public string $language;

    public function __construct(
        int $accountId,
        string $externalId,
        string $name,
        string $template,
        string $language)
    {
        $this->accountId = $accountId;
        $this->externalId = $externalId;
        $this->name = $name;
        $this->template = $template;
        $this->language = $language;
    }
}
