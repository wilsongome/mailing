@extends('layouts.master')

@section('content_header')
    <h4>Whatsapp Number</h4>
@stop

@section('content')

<x-layout.alert_handle />

<form method="post" action="/wpaccount/{{ $wpAccountId }}/number/{{ $wpNumber->id }}">
    <x-form.btn_save />

    <x-wpaccount.tabs wpaccount="{{ $wpAccountId }}" />

    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-sm-6">
            <label class="form-label">Name</label>
            <input required type="text" class="form-control" name="name" id="name" value="{{ $wpNumber->name }}">
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <label class="form-label">Number</label>
            <input required type="text" class="form-control" name="number" id="number" value="{{ $wpNumber->number }}">
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <label class="form-label">External ID</label>
            <input required type="text" class="form-control" name="external_id" id="external_id" value="{{ $wpNumber->external_id }}">
        </div>
    </div>
</form>


@stop