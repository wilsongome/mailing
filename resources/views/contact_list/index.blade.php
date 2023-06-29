@extends('layouts.master')

@section('content_header')
    <h4>Contact lists</h4>
@stop

@section('content')

@if(session('error'))
<x-layout.alert status="Error" message="{{session('error')}}" class="danger" />
@endif
@if(session('success'))
<x-layout.alert status="Success" message="{{session('success')}}" class="success" />
@endif

<x-layout.btn_new route="{{ route('contact_list.create') }}"/>

<table class="table table-hover table-bordered table-sm">
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
        @foreach($contact_lists as $contact_list)
        <tr>
            <td>{{$contact_list->id}}</td>
            <td>{{$contact_list->campaign_id}}</td>
            <td>{{$contact_list->email_template_id}}</td>
            <td>{{$contact_list->name}}</td>
            <td>{{$contact_list->description}}</td>
            <td>{{$contact_list->created_at}}</td>
            <td>
                <a href="/contact_list/{{$contact_list->id}}/edit">
                    <i class="fas fa-edit fa-lg" style="color: green"></i>
                </a>
            </td>
            <td>
                <form method="post" action="/contact_list/{{$contact_list->id}}"> 
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-delete"><i class="fas fa-trash-alt fa-lg" style="color: red"></i></button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@stop
