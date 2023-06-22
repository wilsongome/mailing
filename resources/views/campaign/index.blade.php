@extends('adminlte::page')

@section('title', 'Campaigns')

@section('content_header')
    <h4>Campaigns</h4>
@stop

@section('content')

@if(session('error'))
<x-layout.alert status="Error" message="{{session('error')}}" class="danger" />
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
        <tr>
            <td>1</td>
            <td>Name</td>
            <td>Description</td>
            <td>Created</td>
            <td>
                <a href="/campaign/1/edit">
                    <i class="fas fa-edit fa-lg" style="color: green"></i>
                </a>
            </td>
            <td>
                <form method="post" action="/campaign/1"> 
                    @csrf
                    @method('DELETE')
                    <button type="submit"><i class="fas fa-trash-alt fa-lg" style="color: red"></i></button>
                </form>
            </td>
        </tr>
    </tbody>
</table>

@stop