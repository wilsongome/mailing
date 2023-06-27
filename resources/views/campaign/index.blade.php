@extends('adminlte::page')

@section('title', 'Mailing System')

@section('content_header')
    <h4>Campaigns</h4>
@stop


@section('content')



@if(session('error'))
<x-layout.alert status="Error" message="{{session('error')}}" class="danger" />
@endif
@if(session('success'))
<x-layout.alert status="Success" message="{{session('success')}}" class="success" />
@endif

<x-layout.btn_new route="{{ route('campaign.create') }}"/>

<table class="table table-hover table-bordered table-sm">
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
        @foreach($campaigns as $campaign)
        <tr>
            <td>{{$campaign->id}}</td>
            <td>{{$campaign->name}}</td>
            <td>{{$campaign->description}}</td>
            <td>{{$campaign->created_at}}</td>
            <td>
                <a href="/campaign/{{$campaign->id}}/edit">
                    <i class="fas fa-edit fa-lg" style="color: green"></i>
                </a>
            </td>
            <td>
                <form method="post" action="/campaign/{{$campaign->id}}"> 
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
