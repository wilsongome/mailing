@extends('layouts.master')


@section('content_header')
    <h4>Whatsapp Message Templates</h4>
@stop


@section('content')

<x-layout.alert_handle />

<x-wpaccount.tabs wpaccount="{{ $wpAccountId }}" />

<x-layout.btn_new route="{{ route('wpmessagetemplate.create', [$wpAccountId]) }}"/>

<table class="table table-hover table-bordered table-sm">
    <caption></caption>
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Template</th>
            <th>Created</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        @foreach($wpMessageTemplates as $wpMessageTemplate)
        <tr>
            <td>{{$wpMessageTemplate->id}}</td>
            <td>{{$wpMessageTemplate->name}}</td>
            <td>{{$wpMessageTemplate->template}}</td>
            <td>{{$wpMessageTemplate->created_at}}</td>
            <td>
                <a href="{{ route('wpmessagetemplate.edit', [$wpAccountId, $wpMessageTemplate->id]) }}">
                    <i class="fas fa-edit fa-lg" style="color: green"></i>
                </a>
            </td>
            <td>
                <form method="post" action="{{ route('wpmessagetemplate.destroy', [$wpAccountId, $wpMessageTemplate->id]) }}">
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
