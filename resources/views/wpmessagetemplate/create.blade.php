@extends('layouts.master')

@section('content_header')
    <h4>Whatsapp Message Template</h4>
@stop

@section('content')

<x-layout.alert_handle />

<form method="post" action="/wpaccount/{{ $wpAccountId }}/messagetemplate">
    <x-form.btn_save />

    <x-wpaccount.tabs wpaccount="{{ $wpAccountId }}" />

    @csrf
    <div class="row">
        <div class="col-sm-4">
            <label class="form-label">Name</label>
            <input required type="text" class="form-control" name="name" id="name" value="">
        </div>
        <div class="col-sm-4">
            <label class="form-label">External ID</label>
            <input required type="text" class="form-control" name="external_id" id="external_id" value="">
        </div>
        <div class="col-sm-4">
            <label class="form-label">Language</label>
            <select class="form-control" name="language" id="language">
                <option value="pt_BR">Portuguese (BR)</option>
                <option value="en_US">English (US)</option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <label class="form-label">Template</label>
            <textarea required class="form-control" name="template" id="template"> </textarea>
        </div>
    </div>
</form>


@stop