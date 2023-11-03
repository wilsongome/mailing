@extends('layouts.master')

@section('content_header')
    <h4>User</h4>
@stop

@section('content')

<form method="post" action="{{ route('user.store') }}">
    <x-form.btn_save />
    @csrf
    <div class="row">
        <div class="col-sm-6">
            <label class="form-label">Name</label>
            <input required type="text" class="form-control" name="name" id="name" value="">
        </div>
        <div class="col-sm-6"></div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <label class="form-label">E-mail</label>
            <input required type="text" class="form-control" name="email" id="email" value="">
        </div>
        <div class="col-sm-6"></div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <label class="form-label">Password</label>
            <input required type="password" class="form-control" name="password" id="password" value="">
        </div>
        <div class="col-sm-6"></div>
    </div>
</form>


@stop