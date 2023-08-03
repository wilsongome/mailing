<?php
namespace App\Domain\ContactList;

use App\Domain\Message\EmailMessage;
use App\Domain\Message\EmailMessageHandler;
use App\Models\ContactList;
use App\Models\EmailTemplate;
use Exception;

class ContactListHandler{

    private ContactList $contactList;

    public function __construct(ContactList $contactList)
    {
        $this->contactList = $contactList;
    }

    private function getDataFromFile(string $filePath): array
    {
        $contactListFile = new ContactListFile();
        $contents = $contactListFile->content($filePath);
        if(!$contents){
            return [];
        }
        return $contents;
    }

    public function addToQueue()
    {
        $result = [
            'contactList' => $this->contactList,
            'registers' => 0,
            'ok' => 0,
            'errors'=> 0,
            'error_log' => []
        ];

        $emailTemplate = EmailTemplate::find($this->contactList->email_template_id);
        if(!$emailTemplate){
            $result['error_log'][0]["E-mail template missing"];
            return $result;
        }

        $contactListData = $this->getDataFromFile($this->contactList->file_path);
        if(!$contactListData){
            $result['error_log'][0]["No contacts to send!"];
            return $result;
        }

        $result['registers'] = count($contactListData);

        $this->setStatus('TO_QUEUE');

        try{

            $cont = 0;
            foreach($contactListData as $data){
                $cont++;

                $emailMessage = new EmailMessage(
                    $data,
                    $emailTemplate->body,
                    $emailTemplate->title,
                    new Email(isset($data['EMAIL'])  ? $data['EMAIL'] : 'empty')
                );

                $emailMessageHandler = new EmailMessageHandler($emailMessage);
                $queuedMessage = $emailMessageHandler->queueMessage(
                    $this->contactList->id,
                    $result['registers'],
                    $cont
                );

                if( !$queuedMessage['status'] ){
                    $result['errors']++;
                    $result['error_log'][$cont]['values'] = $data;
                    $result['error_log'][$cont]['error']  = $queuedMessage['error'];
                    continue;
                }
                $result['ok']++;
            }

            $this->setStatus('SENDING');

        }catch(Exception $e){
            $result['error_log'][0][$e->getMessage()];
        }

        return $result;
    }


    public function setStatus(string $newStatus): bool
    {
        try{
        
            if(!ContactListStatus::canChange($this->contactList->status, $newStatus)){
                return false;
            }
            $this->contactList->status = $newStatus;
            $this->contactList->save();

        }catch(Exception $e){
            return false;
        }
        return true;
    }


}
