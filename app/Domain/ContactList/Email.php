<?php

namespace App\Domain\ContactList;

class Email{

    public string $email;

    public function __construct(string $email)
    {
        $email = trim($email);
        if($this->validate($email)){
            $this->email = $email;
        }
    }

    private function validate(string $email): bool
    {
        if( !filter_var($email, FILTER_VALIDATE_EMAIL)){
            return false;
        }
        return true;
    }

    public function __toString()
    {
        return $this->email;
    }
}