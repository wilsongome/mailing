<?php
namespace App\Domain\Whatsapp\Message\Response;

class WpMessageResponse{

    private int $httpStatusCode;
    private string $id;
    private string $messageStatus;
    private string $responseBody;

    public function __construct(
        int $httpStatusCode,
        string $id,
        string $messageStatus,
        string $responseBody)
    {
        $this->httpStatusCode = $httpStatusCode;
        $this->id = $id;
        $this->messageStatus = $messageStatus;
        $this->responseBody = $responseBody;
    }

    public function httpStatusCode()
    {
        return $this->httpStatusCode;
    }

    public function id()
    {
        return $this->id;
    }

    public function messageStatus()
    {
        return $this->messageStatus;
    }

    public function responseBody()
    {
        return $this->responseBody;
    }
}
