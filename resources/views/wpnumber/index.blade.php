@extends('layouts.master')


@section('content_header')
<x-layout.page_header pageTitle="Whatsapp Numbers" />
@stop


@section('content')

<x-layout.alert_handle />

<x-wpaccount.tabs wpaccount="{{ $wpAccountId }}" />

<x-layout.btn_new route="{{ route('wpnumber.create', [$wpAccountId]) }}"/>

<table class="table table-hover table-bordered table-sm">
    <caption></caption>
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Number</th>
            <th>Created</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        @foreach($wpNumbers as $wpNumber)
        <tr>
            <td>{{$wpNumber->id}}</td>
            <td>{{$wpNumber->name}}</td>
            <td>{{$wpNumber->number}}</td>
            <td>{{$wpNumber->created_at}}</td>
            <td>
                <a href="{{ route('wpnumber.edit', [$wpAccountId, $wpNumber->id]) }}">
                    <i class="fas fa-edit fa-lg" style="color: green"></i>
                </a>
            </td>
            <td>
                <form method="post" action="{{ route('wpnumber.destroy', [$wpAccountId, $wpNumber->id]) }}">
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
