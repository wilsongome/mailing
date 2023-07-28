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
    Listar as contact lists aqui
</div>

@stop