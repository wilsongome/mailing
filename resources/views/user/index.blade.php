@extends('layouts.master')


@section('content_header')
    <h4>Users</h4>
@stop


@section('content')

<x-layout.alert_handle />

<x-layout.btn_new route="{{ route('user.create') }}"/>

<table class="table table-hover table-bordered table-sm">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>E-mail</th>
            <th>Created</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <td>{{$user->id}}</td>
            <td>{{$user->name}}</td>
            <td>{{$user->email}}</td>
            <td>{{$user->created_at}}</td>
            <td>
                <a href="/user/{{$user->id}}/edit">
                    <i class="fas fa-edit fa-lg" style="color: green"></i>
                </a>
            </td>
            <td>
                <form method="post" action="/user/{{$user->id}}"> 
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-delete">
                        <i class="fas fa-trash-alt fa-lg" style="color: red"></i>
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@stop
