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
                <option value="{{$campaign->id}}">{{$campaign->id}} | {{$campaign->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-sm-6">
            <label class="form-label">E-mail template</label>
            <select required class="form-control" id="email_template_id" name="email_template_id">
                <option value="">Select</option>
                @foreach($emailTemplates as $emailTemplate)
                <option value="{{$emailTemplate->id}}">{{$emailTemplate->id}} | {{$emailTemplate->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <label class="form-label">Name</label>
            <input required type="text" class="form-control" name="name" id="name">
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <label class="form-label">Description</label>
            <textarea class="form-control" name="description" id="description" rows="3"></textarea>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <label class="form-label">CSV File (Contact list)</label> 
            <i data-toggle="tooltip" data-placement="top" title="Submit a CSV file separated by semicolon (;). The first line of the file must be a header and the first column must be EMAIL, the second one must be NAME, then the next columns are free." class="fas fa-question-circle"></i>
            <input required class="form-control" type="file" name="contact_list_file" id="contact_list_file" />
        </div>
    </div>
</form>


@stop