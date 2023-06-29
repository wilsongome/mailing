@extends('layouts.master')

@section('content_header')
    <h4>E-mail template</h4>
@stop


@section('content')

<form method="post" action="{{ route('email_template.store') }}">
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
