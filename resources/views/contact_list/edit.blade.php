@extends('layouts.master')

@section('content_header')
    <h4>Contact list</h4>
@stop

@section('content')

<form enctype="multipart/form-data" method="post" action="{{ route('contact_list.store') }}">
    <x-form.btn_save />
    @csrf
    <div class="row">
        <div class="col-sm-6">
            <label class="form-label">Campaign</label>
            <select required class="form-control" id="campaign_id" name="campaign_id">
                <option value="">Select</option>
                @foreach($campaigns as $campaign)
                <option {{$campaign->id == $contactList->campaign_id ? 'selected' : null}} value="{{$campaign->id}}">{{$campaign->id}} | {{$campaign->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-sm-6">
            <label class="form-label">E-mail template</label>
            <select required class="form-control" id="email_template_id" name="email_template_id">
                <option value="">Select</option>
                @foreach($email_templates as $email_template)
                <option  {{$email_template->id == $contactList->campaign_id ? 'selected' : null}} value="{{$email_template->id}}">{{$email_template->id}} | {{$email_template->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <label class="form-label">Name</label>
            <input required type="text" class="form-control" name="name" id="name" value="{{$contactList->name}}">
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <label class="form-label">Description</label>
            <textarea class="form-control" name="description" id="description" rows="3">{{$contactList->description}}</textarea>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <label class="form-label">CSV File (Contact list)</label> 
            <i data-toggle="tooltip" data-placement="top" title="Submit a CSV file separated by semicolon (;). The first line of the file must be a header and the first column must be EMAIL, the second one must be NAME, then the next columns are free." class="fas fa-question-circle"></i>
            <input class="form-control" type="file" name="contact_list_file" id="contact_list_file" />
            <p>{{$contactList->file_name}}</p>
        </div>
    </div>
</form>


@stop