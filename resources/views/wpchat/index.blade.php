@extends('layouts.master')


@section('content_header')
    <h4>Whatsapp Chats</h4>
@stop


@section('content')

<x-layout.alert_handle />

<x-layout.btn_new route="{{ route('wpchat.create') }}"/>

<table class="table table-hover table-bordered table-sm">
    <caption></caption>
    <thead>
        <tr>
            <th>#</th>
            <th>Number</th>
            <th>Contact</th>
            <th>Contact Number</th>
            <th>Last Contact Message</th>
            <th>Status</th>
            <th>Show</th>
        </tr>
    </thead>
    <tbody>
        @foreach($wpChats as $wpChat)
        <tr>
            <td>{{$wpChat->id}}</td>
            <td>{{$wpChat->wp_number_id}}</td>
            <td>{{$wpChat->contact_id}}</td>
            <td>5511989995982</td>
            <td>{{$wpChat->last_contact_message}}</td>
            <td>{{$wpChat->status}}</td>
            <td>
                <a href="{{ route('wpchat.edit', [$wpChat->id]) }}">
                    <i class="fas fa-edit fa-lg" style="color: green"></i>
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@stop
