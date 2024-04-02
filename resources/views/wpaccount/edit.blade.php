@extends('layouts.master')

@section('content_header')
    <h4>Whatsapp Account</h4>
@stop

@section('content')

<x-layout.alert_handle />

<form method="post" action="/wpaccount/{{ $wpaccount->id }}">
    <x-form.btn_save />

    <x-wpaccount.tabs wpaccount="{{ $wpaccount->id }}" />

    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-sm-6">
            <label class="form-label">Name</label>
            <input required type="text" class="form-control" name="name" id="name" value="{{ $wpaccount->name }}">
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <label class="form-label">External ID</label>
            <input required type="text" class="form-control" name="external_id" id="external_id" value="{{ $wpaccount->external_id }}">
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <label class="form-label">Description</label>
        <textarea
        class="form-control"
        name="description"
        id="description"
        rows="3">{{ $wpaccount->description }}</textarea>
        </div>
    </div>
</form>


@stop