@extends('layouts.master')


@section('content_header')
    <h4>Whatsapp Accounts</h4>
@stop


@section('content')

<x-layout.alert_handle />

<x-layout.btn_new route="{{ route('wpaccount.create') }}"/>

<table class="table table-hover table-bordered table-sm">
    <caption></caption>
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Description</th>
            <th>Created</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        @foreach($wpAccounts as $wpAccount)
        <tr>
            <td>{{$wpAccount->id}}</td>
            <td>{{$wpAccount->name}}</td>
            <td>{{$wpAccount->description}}</td>
            <td>{{$wpAccount->created_at}}</td>
            <td>
                <a href="{{ route('wpaccount.edit', [$wpAccount->id]) }}">
                    <i class="fas fa-edit fa-lg" style="color: green"></i>
                </a>
            </td>
            <td>
                <form method="post" action="{{ route('wpaccount.destroy', [$wpAccount->id]) }}">
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
