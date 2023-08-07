@extends('layouts.master')

@section('content_header')
    <h4>E-mail template</h4>
@stop

@section('content')

<x-layout.alert_handle />

<form method="post" action="/email_template/{{ $emailTemplate->id }}">
    <x-form.btn_save />
    @csrf
    @method('PUT')
    <div class="row">
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
            <input type="text" class="form-control" name="title" id="title" value="{{ $emailTemplate->title }}">
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <label class="form-label">Body</label>
            <textarea class="form-control" name="body" id="body" rows="60">{{ $emailTemplate->body }}</textarea>
        </div>
    </div>
</form>

<script src="https://cdn.tiny.cloud/1/jdxqdz2yqo4nis0fcx7y20c1moyjf1o0vpycvc2yfa4q2kq7/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
      selector: '#body',
      plugins: 'code anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
      toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat | code',
    });
  </script>
@stop