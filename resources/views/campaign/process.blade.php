@extends('layouts.master')

@section('content_header')
    <h4>Campaigns</h4>
@stop

@section('content')

@if(isset($success))
<x-layout.alert status="Success" message="{{$success}}" class="success" />
@endif

<div class="row">
    <div class="col-sm-10"></div>
    <div class="col-sm-2">
        <form method="post" action="/campaign/{{ $campaign->id }}/processing">
            @csrf
            <button class="btn btn-success" type="submit">
                <i class="fas fa-sync"></i>
                 Process Now
            </button>
        </form>
    </div>
</div>

<x-campaign.tabs campaign="{{ $campaign->id }}" />

<div class='contact_list-grid'>
    <table class='table table-hover table-sm'>
        <caption></caption>
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>File</th>
                <th>Registers</th>
                <th>Processed</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($contactLists as $contactList)
            <tr>
                <td>{{$contactList->name}}</td>
                <td>{{$contactList->description}}</td>
                <td>{{$contactList->file_name}}</td>
                <td>{{$contactList->registers}}</td>
                <td>{{$contactList->processed_registers}}</td>
                <td>
                    <span class="badge badge-{{ ContactListStatus::statusColor($contactList->status) }}">
                        {{$contactList->status}}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@stop