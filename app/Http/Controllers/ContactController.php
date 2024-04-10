<?php

namespace App\Http\Controllers;

use App\Domain\Contact\Contact;
use App\Models\Contact as ContactModel;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function find(int $contactId) : Contact
    {
        $search = ContactModel::find($contactId);
        $contact = new Contact();
        $contact->id = $search->id;
        $contact->name = $search->name;
        $contact->email = $search->email;
        $contact->whatsappNumber = $search->whatsapp_number;
        $contact->telephoneNumber = $search->telephone_number;
        return $contact;
    }

    public function index(Request $request)
    {
        return true;
    }
}
