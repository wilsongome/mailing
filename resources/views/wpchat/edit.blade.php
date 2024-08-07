@extends('layouts.master')

@section('content_header')
    <div class="row"></div>
@stop

@section('content')

<script type="text/javascript" src="{{asset('js/chat.js')}}"></script>

<x-layout.alert_handle />

<div class="row">
    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-secondary">
                <i class="far fa-paper-plane"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text" id="system-name">{{ $wpNumber->name }}</span>
                <span class="info-box-number">{{ $wpNumber->number }}</span>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-info">
                <i class="far fa-user"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text" id="contact-name">{{ $contact->name }}</span>
                <span class="info-box-number">{{ $contact->whatsappNumber }}</span>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon {{ $styleStatus->class }}">
                <i class="{{ $styleStatus->icon }}"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">Status</span>
                <span class="info-box-number">{{ $wpChat->status->name }}</span>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-warning">
                <i class="far fa-clock"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">Time to close</span>
                <span class="info-box-number">{{ $wpChat->getMinutesToChatClosing() }} Min</span>
            </div>
        </div>
    </div>

</div>


    @csrf
    @method('PUT')

    <x-wpchat.chat />


    <x-wpchat.templates :templates="$wpMessageTemplates" />

    <x-wpchat.documents />

@stop