<?php
namespace App\Domain\Whatsapp\Message\Response;

class WpMessageResponse{

    private int $httpStatusCode;
    private string $wpMessageId;
    private string $wpMessageStatus;
    private string $responseBody;

    public function __construct(
        int $httpStatusCode,
        string $wpMessageId,
        string $wpMessageStatus,
        string $responseBody)
    {
        $this->httpStatusCode = $httpStatusCode;
        $this->wpMessageId = $wpMessageId;
        $this->wpMessageStatus = $wpMessageStatus;
        $this->responseBody = $responseBody;
    }
}
