@extends('layouts.master')

@section('content_header')
    <h4>Whatsapp Number</h4>
@stop

@section('content')

<x-layout.alert_handle />

<form method="post" action="/wpaccount/{{ $wpAccountId }}/number">
    <x-form.btn_save />

    <x-wpaccount.tabs wpaccount="{{ $wpAccountId }}" />

    @csrf
    <div class="row">
        <div class="col-sm-6">
            <label class="form-label">Name</label>
            <input required type="text" class="form-control" name="name" id="name" value="">
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <label class="form-label">Number</label>
            <input required type="text" class="form-control" name="number" id="number" value="">
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <label class="form-label">External ID</label>
            <input required type="text" class="form-control" name="external_id" id="external_id" value="">
        </div>
    </div>
</form>


@stop