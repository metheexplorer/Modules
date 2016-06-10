@extends('layouts.main')
@section('title', 'Dashboard')
@section('heading', 'Dashboard')
@section('breadcrumb')
    @parent
@stop
@section('content')

    <div class="col-xs-12">
        @include('flash::message')
        {{--@include('Dashboard::statistics')--}}
        <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">Newly Registered Agencies<span class="small"> - within a month</span></h3>
            <a href="{{route('agency.create')}}" class="btn btn-primary btn-flat pull-right">Add New Agency</a>
        </div>
        <div class="box-body">
            <table id="new-agencies" class="table table-bordered table-striped dataTable">
                <thead>
                <tr>
                    <th>Agency ID</th>
                    <th>Company Name</th>
                    <th>Email</th>
                    <th>Database Name</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>

    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">Expiring Agencies<span class="small"> - within a month</span></h3>
        </div>
        <div class="box-body">
            <table id="expiring-agencies" class="table table-bordered table-striped dataTable">
                <thead>
                <tr>
                    <th>Agency ID</th>
                    <th>Company Name</th>
                    <th>Email</th>
                    <th>Database Name</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        oTable = $('#new-agencies').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": appUrl + "/dashboard/newAgencyData",
            "columns": [
                {data: 'agency_id', name: 'agency_id'},
                {data: 'name', name: 'name'},
                {data: 'email_id', name: 'email_id'},
                {data: 'company_database_name', name: 'company_database_name'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

        eTable = $('#expiring-agencies').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": appUrl + "/dashboard/expiringAgencyData",
            "columns": [
                {data: 'agency_id', name: 'agency_id'},
                {data: 'name', name: 'name'},
                {data: 'email_id', name: 'email_id'},
                {data: 'company_database_name', name: 'company_database_name'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    });
</script>
@stop