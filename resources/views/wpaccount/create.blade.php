@extends('layouts.master')

@section('content_header')
    <h4>Whatsapp Account</h4>
@stop

@section('content')

<form method="post" action="{{ route('wpaccount.store') }}">
    <x-form.btn_save />
    @csrf
    <div class="row">
        <div class="col-sm-6">
            <label class="form-label">Name</label>
            <input required type="text" class="form-control" name="name" id="name" value="">
        </div>
        <div class="col-sm-6"></div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <label class="form-label">External ID</label>
            <input required type="text" class="form-control" name="external_id" id="external_id" value="">
        </div>
        <div class="col-sm-6"></div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <label class="form-label">Description</label>
        <textarea
        class="form-control"
        name="description"
        id="description"
        rows="3"></textarea>
        </div>
    </div>
</form>


@stop