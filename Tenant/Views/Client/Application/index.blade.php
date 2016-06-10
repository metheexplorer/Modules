@extends('layouts.tenant')
@section('title', 'Application List')
@section('breadcrumb')
    @parent
    <li><a href="{{url('tenant/client')}}" title="All Clients"><i class="fa fa-users"></i> Clients</a></li>
    <li>View</li>
@stop
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-sm-2">
                <div class="container">
                    <img src="https://scontent-lax3-1.xx.fbcdn.net/v/t1.0-9/1936510_10207216981375364_4596889339024157957_n.jpg?oh=f3031e9add8769ca489e5865a54b6bc4&oe=57B0E02E"
                         class="img-rounded" alt="Cinque Terre" width="150" height="150">
                </div>
            </div>
            <div class="col-sm-10">
                <div class="row">

                    <h4>{{$client->first_name}} {{$client->middle_name}} <b>{{$client->last_name}}</b></h4>

                    <p>E {{$client->email}} | P {{$client->number}}</p>

                    <p>
                        {{ $client->street }}
                        {{ $client->suburb }}
                        {{ $client->state }}
                        {{ $client->postcode }}
                        {{ get_country($client->country_id) }}
                    </p>


                </div>
                <div class="row">
                    <nav class="navbar navbar-default">
                        <div class="container-fluid">
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                                        data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                                <a class="navbar-brand visible-xs" href="#">AMS</a>
                            </div>

                            @include('Tenant::Client/navbar')
                        </div>
                        <!--/.container-fluid -->
                    </nav>

                </div>


            </div>
        </div>

        <div class="col-xs-12 col-md-12">
            @include('flash::message')
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Manage Applications</h3>
                    <a href="{{route('tenant.application.create', $client->client_id)}}"
                       class="btn btn-primary btn-flat pull-right"><i class="fa  fa-graduation-cap"></i> Enroll Now</a>
                </div>
                <div class="box-body table-responsive">

                    <table id="applications" class="table table-bordered table-striped dataTable">
                        <thead>
                        <tr>
                            <th>Application ID</th>
                            <th>Institute Name</th>
                            <th>Course Name</th>
                            <th>Start Date</th>
                            <th>Finish Date</th>
                            <th>Student Id</th>
                            <th>Total Tuition Fee</th>
                            <th>Status</th>
                            <th>Added By</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            oTable = $('#applications').DataTable({
                "processing": true,
                "serverSide": true,

                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": true,

                "ajax": appUrl + "/tenant/applications/"+ <?php echo $client->client_id ?> +"/data",
                "columns": [
                    {data: 'application_id', name: 'application_id'},
                    {data: 'name', name: 'name'},
                    {data: 'course_name', name: 'course_name'},
                    {data: 'orientation_date', name: 'orientation_date'},
                    {data: 'end_date', name: 'end_date'},
                    {data: 'student_id', name: 'student_id'},
                    {data: 'tuition_fee', name: 'tuition_fee'},
                    {data: 'status', name: 'status'},
                    {data: 'added_by', name: 'added_by'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
        });
    </script>
@stop
