@extends('layouts.master')

@section('content_header')
    <h4>Whatsapp Chat</h4>
@stop

@section('content')

<x-layout.alert_handle />

<div class="row">
    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-secondary">
                <i class="far fa-paper-plane"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">Frow Message</span>
                <span class="info-box-number">+15550902559</span>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-info">
                <i class="far fa-user"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">Wilson Gomes</span>
                <span class="info-box-number">55 11 989995982</span>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-success">
                <i class="fas fa-sync-alt"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">Status</span>
                <span class="info-box-number">OPEN</span>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-warning">
                <i class="fas fa-comment-slash"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">Status</span>
                <span class="info-box-number">CLOSED</span>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-danger">
                <i class="fas fa-ban"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">Status</span>
                <span class="info-box-number">FINISHED</span>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-primary">
                <i class="far fa-clock"></i>
            </span>
            <div class="info-box-content">
                <span class="info-box-text">Time to close</span>
                <span class="info-box-number">10 Min</span>
            </div>
        </div>
    </div>

</div>

<form method="post" action="/wpchat/{{ $wpChat->id }}">

    @csrf
    @method('PUT')

    <x-wpchat.chat />

</form>

@stop