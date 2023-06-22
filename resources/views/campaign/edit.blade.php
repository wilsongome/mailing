@extends('adminlte::page')

@section('title', 'Campaigns')

@section('content_header')
    <h4>Campaigns</h4>
@stop

@section('content')

<form method="post" action="campaign/1">
    <x-form.btn_save />
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" class="form-control" name="name" id="name" value="{{ $campaign->name }}">
    </div>
    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea class="form-control" name="description" id="description" rows="3">{{ $campaign->description }}</textarea>
    </div>
</form>


@stop