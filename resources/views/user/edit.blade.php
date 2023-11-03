@extends('layouts.master')

@section('content_header')
    <h4>Users</h4>
@stop

@section('content')

<x-layout.alert_handle />

<form method="post" action="/user/{{ $user->id }}">
    <x-form.btn_save />

    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-sm-6">
            <label class="form-label">Name</label>
            <input required type="text" class="form-control" name="name" id="name" value="{{ $user->name }}">
        </div>
        <div class="col-sm-6"></div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <label class="form-label">E-mail</label>
            <input required type="text" class="form-control" name="email" id="email" value="{{ $user->email }}">
        </div>
        <div class="col-sm-6"></div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <label class="form-label">Password</label>
            <input type="text" class="form-control" name="password" id="password" value="">
        </div>
        <div class="col-sm-6"></div>
    </div>
</form>


@stop