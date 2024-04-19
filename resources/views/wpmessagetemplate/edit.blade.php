@extends('layouts.master')

@section('content_header')
    <x-layout.page_header pageTitle="Message Template" />
@stop

@section('content')

<script type="text/javascript" src="{{asset('js/wptemplate.js')}}"></script>

<x-layout.alert_handle />

<form method="post" action="/wpaccount/{{ $wpAccountId }}/messagetemplate/{{ $wpMessageTemplate->id }}" enctype="multipart/form-data">

    <x-wpaccount.tabs wpaccount="{{ $wpAccountId }}" />

    <x-form.btn_save />

    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-sm-4">
            <label class="form-label">Name</label>
            <input required type="text" class="form-control" name="name" id="name" value="{{ $wpMessageTemplate->name }}">
        </div>
        <div class="col-sm-4">
            <label class="form-label">External ID</label>
            <input required type="text" class="form-control" name="external_id" id="external_id" value="{{ $wpMessageTemplate->external_id }}">
        </div>
        <div class="col-sm-4">
            <label class="form-label">Language</label>
            <select class="form-control" name="language" id="language">
                <option {{ $wpMessageTemplate->language == "pt_BR" ? "selected" : null }} value="pt_BR">Portuguese (BR)</option>
                <option {{ $wpMessageTemplate->language == "en_US" ? "selected" : null }} value="en_US">English (US)</option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
        <label class="form-label">Template</label>
            <textarea maxlength="1032" rows="5" required class="form-control" name="template" id="template">{{ $wpMessageTemplate->template }}</textarea>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <label class="form-label">Header</label>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-2">
            <select class="form-control" name="headerType" id="headerType"  onchange="handleHeaderParameter(this.options[this.selectedIndex].value)">
                <option value="">No header</option>
                <optgroup label="Static Values">
                    <option value="text">Text Value</option>
                </optgroup>
                <optgroup label="Media">
                    <option value="document">Document</option>
                    <option value="video">Video</option>
                    <option value="image">Image</option>
                </optgroup>
            </select>
        </div>
        <div class="col-sm-6">
            <input maxlength="60" disabled class="form-control" type="text" name="staticHeaderValue" id="staticHeaderValue" value="" placeholder="Static Text"/>
        </div>
        <div class="col-sm-4">
            <input disabled class="form-control" type="file" name="mediaFile" id="mediaFile"  placeholder="Select a media"/>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <label class="form-label">Footer</label>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-8">
        <input maxlength="60" class="form-control" type="text" name="staticFooterValue" id="staticFooterValue" value="" placeholder="Static Text"/>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <label class="form-label">Parameters</label>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-2">
            <select class="form-control" name="parameterType" id="parameterType" onchange="handleParameter()">
                <option value="">No Parameters</option>
                <option value="header">Header</option>
                <option value="body">Body</option>
            </select>
        </div>
        <div class="col-sm-2">
            <select class="form-control" name="parameterDataFrom" id="parameterDataFrom" onchange="handleParameter()">
                <option value="">No parameters</option>
                <optgroup label="Static Parameters">
                    <option value="static">Static Value</option>
                </optgroup>
                <optgroup label="Dynamic Parameter">
                    <option value="execution_time">Merged at execution time</option>
                </optgroup>
                <optgroup label="From Contact">
                    <option value="contact_name">Name</option>
                    <option value="contact_email">E-mail</option>
                    <option value="contact_whatsapp_number">Whatsapp Number</option>
                    <option value="contact_telephone_number">Telephone Number</option>
                </optgroup>
            </select>
        </div>
        <div class="col-sm-4">
            <input maxlength="60" disabled class="form-control" type="text" name="staticParameterValue" id="staticParameterValue" value="" placeholder="Static Text"/>
        </div>
    </div>
</form>

<x-wptemplate.parameters_grid :storedParameters="['passsar_array' => 'Diretamente aqui']"/>


@stop