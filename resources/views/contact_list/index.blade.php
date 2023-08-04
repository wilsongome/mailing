@extends('layouts.master')

@section('content_header')
    <h4>Contact lists</h4>
@stop

@section('content')

<x-layout.alert_handle />

<x-layout.btn_new route="{{ route('contact_list.create') }}"/>

<table class="table table-hover table-bordered table-sm">
    <caption></caption>
    <thead>
        <tr>
            <th>#</th>
            <th>Campaign</th>
            <th>E-mail template</th>
            <th>Name</th>
            <th>Description</th>
            <th>Created</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        @foreach($contactLists as $contactList)
        <tr>
            <td>{{$contactList->id}}</td>
            <td>{{$contactList->campaign_id}}</td>
            <td>{{$contactList->email_template_id}}</td>
            <td>{{$contactList->name}}</td>
            <td>{{$contactList->description}}</td>
            <td>{{$contactList->created_at}}</td>
            <td>
                <a href="/contact_list/{{$contactList->id}}/edit">
                    <i class="fas fa-edit fa-lg" style="color: green"></i>
                </a>
            </td>
            <td>
                <form method="post" action="/contact_list/{{$contactList->id}}">
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
