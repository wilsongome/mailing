@extends('layouts.master')

@section('content_header')
    <h4>Campaigns</h4>
@stop

@section('content')

@if(isset($success))
<x-layout.alert status="Success" message="{{$success}}" class="success" />
@endif

<form method="post" action="/campaign/{{ $campaign->id }}">
    <x-form.btn_save />

    <x-campaign.tabs campaign="{{ $campaign->id }}" />

    @csrf
    @method('PUT')
    <div class="mb-3">
        <label class="form-label">Name</label>
        <input required type="text" class="form-control" name="name" id="name" value="{{ $campaign->name }}">
    </div>
    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea class="form-control" name="description" id="description" rows="3">
            {{ $campaign->description }}
        </textarea>
    </div>
</form>


@stop