@extends('adminlte::page')

@section('title', 'Mailing System')

@section('content_header')
    <h4>E-mail template</h4>
@stop

@section('content')

<form method="post" action="{{ route('email_template.store') }}">
    <x-form.btn_save />
    @csrf
    <div class="mb-3">
        <label class="form-label">Campanha</label>
        <select required class="form-control" id="campaign_id" name="campaign_id">
            <option value="">Select</option>
            @foreach($campaigns as $campaign)
            <option value="{{$campaign->id}}">{{$campaign->id}} | {{$campaign->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" class="form-control" name="name" id="name">
    </div>
    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea class="form-control" name="description" id="description" rows="3"></textarea>
    </div>
</form>


@stop