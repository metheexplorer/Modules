@extends('layouts.tenant')
@section('title', 'Update Client')
@section('heading', 'Update Client')
@section('breadcrumb')
    @parent
    <li><a href="{{url('tenant/clients')}}" title="All Clients"><i class="fa fa-users"></i> Clients</a></li>
    <li>Update</li>
@stop
@section('content')
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Client Details</h3>
            </div>
            @include('flash::message')
            {!!Form::model($client, array('route' => array('tenant.client.update', $client->client_id), 'class' => 'form-horizontal form-left', 'method' => 'put'))!!}
            {!!Form::hidden('user_id', $client->user_id)!!}
            @include('Tenant::Client/form')
            <div class="box-footer clearfix">
                <input type="submit" class="btn btn-primary pull-right" value="Update"/>
            </div>
            {!!Form::close()!!}
        </div>
    </div>
@stop
