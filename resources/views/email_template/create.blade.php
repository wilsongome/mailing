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

<script src="https://cdn.tiny.cloud/1/jdxqdz2yqo4nis0fcx7y20c1moyjf1o0vpycvc2yfa4q2kq7/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
      selector: '#body',
      plugins: 'code anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
      toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat | code',
    });
  </script>

@stop
