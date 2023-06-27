@extends('adminlte::page')

@section('title', 'Mailing System')

@section('content_header')
    <h4>E-mail template</h4>
@stop

@section('content')

@if(isset($success))
<x-layout.alert status="Success" message="{{$success}}" class="success" />
@endif

<form method="post" action="/email_template/{{ $emailTemplate->id }}">
    <x-form.btn_save />
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-sm-6">
            <label class="form-label">Campanha</label>
            <select required class="form-control" id="campaign_id" name="campaign_id">
                <option value="">Select</option>
                @foreach($campaigns as $campaign)
                <option {{$campaign->id == $emailTemplate->campaign_id ? 'selected' : null}} value="{{$campaign->id}}">{{$campaign->id}} | {{$campaign->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-sm-6">
            <label class="form-label">Name</label>
            <input type="text" class="form-control" name="name" id="name" value="{{ $emailTemplate->name }}">
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <label class="form-label">Description</label>
            <textarea class="form-control" name="description" id="description" rows="3">{{ $emailTemplate->description }}</textarea>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <label class="form-label">Title</label>
            <input type="text" class="form-control" name="title" id="title">
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <label class="form-label">Body</label>
            <textarea class="form-control" name="body" id="body" rows="10"></textarea>
        </div>
    </div>
</form>

<script src="https://cdn.ckeditor.com/ckeditor5/38.0.1/classic/ckeditor.js"></script>
<script>
   
        ClassicEditor
        .create( document.querySelector( '#body' ) )
        .catch( error => {
            console.error( error );
        } );

</script>
<style>
    .ck-editor__editable {
        min-height: 200px;
        margin-bottom: 15px;
    }
</style>

@stop