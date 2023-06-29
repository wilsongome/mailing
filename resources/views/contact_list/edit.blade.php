@extends('layouts.master')

@section('content_header')
    <h4>Contact list</h4>
@stop

@section('content')

@if(isset($success))
<x-layout.alert status="Success" message="{{$success}}" class="success" />
@endif

<form method="post" action="/contact_list/{{ $contact_list->id }}">
    <x-form.btn_save />
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label class="form-label">Name</label>
        <input required type="text" class="form-control" name="name" id="name" value="{{ $contact_list->name }}">
    </div>
    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea class="form-control" name="description" id="description" rows="3">{{ $contact_list->description }}</textarea>
    </div>
</form>


@stop