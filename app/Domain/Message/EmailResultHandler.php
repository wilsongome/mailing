<?php
namespace App\Domain\Message;

class EmailResultHandler{

    private array $jobResult = [];
    
    public function __construct(array $jobResult)
    {
        $this->jobResult = $jobResult;
    }

    public function execute()
    {
        /*
            Esse método vai processar o resultado da job e atualizar o banco de dados
        */
    }

}