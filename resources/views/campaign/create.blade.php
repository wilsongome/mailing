@extends('layouts.master')

@section('content_header')
    <h4>Campaigns</h4>
@stop

@section('content')

<form method="post" action="{{ route('campaign.store') }}">
    <x-form.btn_save />
    @csrf
    <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" class="form-control" name="name" id="name">
    </div>
    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea class="form-control" name="description" id="description" rows="3"></textarea>
    </div>
</form>


@stop