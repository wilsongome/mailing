@extends('layouts.master')

@section('content_header')
    <h4>Campaigns</h4>
@stop

@section('content')

<x-layout.alert_handle />


<x-campaign.tabs campaign="{{ $campaign->id }}" />

<table class="table table-sm table-bordered">
    <caption></caption>
    <tbody>
        @foreach ($campaignHistories as $campaignHistory)
        <thead class="bg-secondary">
            <tr>
                <th>Start date</th>
                <th>End date</th>
            </tr>
        </thead>
        <tr>
            <td><b>{{$campaignHistory['created_at']}}</b></td>
            <td><b>{{$campaignHistory['updated_at']}}</b></td>
        </tr>
        
        @foreach ($campaignHistory['process_data']['contactLists'] as $key => $values)
        <tr>
            <td colspan="2">
                <div class="row">
                    <div class="col-sm-3"><label class="badge badge-light">Contact List</label></div>
                    <div class="col-sm-3"><label class="badge badge-light">Registers</label></div>
                    <div class="col-sm-3"><label class="badge badge-light">Processed Registers</label></div>
                    <div class="col-sm-3"><label class="badge badge-light">File</label></div>
                </div>
                <div class="row">
                    <div class="col-sm-3">{{$values['name']}}</div>
                    <div class="col-sm-3">{{$values['registers']}}</div>
                    <div class="col-sm-3">{{$values['processed_registers']}}</div>
                    <div class="col-sm-3">{{$values['file_name']}}</div>
                </div>
            </td>
        </tr>
        @endforeach
        
        @endforeach
    </tbody>
</table>
    
@stop