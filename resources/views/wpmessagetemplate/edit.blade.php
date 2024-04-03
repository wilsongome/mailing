@extends('layouts.master')

@section('content_header')
    <h4>Whatsapp Message Template</h4>
@stop

@section('content')

<x-layout.alert_handle />

<form method="post" action="/wpaccount/{{ $wpAccountId }}/messagetemplate/{{ $wpMessageTemplate->id }}">
    <x-form.btn_save />

    <x-wpaccount.tabs wpaccount="{{ $wpAccountId }}" />

    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-sm-6">
            <label class="form-label">Name</label>
            <input required type="text" class="form-control" name="name" id="name" value="{{ $wpMessageTemplate->name }}">
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
        <label class="form-label">Template</label>
            <textarea required class="form-control" name="template" id="template">{{ $wpMessageTemplate->template }}</textarea>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <label class="form-label">External ID</label>
            <input required type="text" class="form-control" name="external_id" id="external_id" value="{{ $wpMessageTemplate->external_id }}">
        </div>
    </div>
</form>


@stop