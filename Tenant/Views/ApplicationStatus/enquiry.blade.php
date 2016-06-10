@extends('layouts.tenant')
@section('title', 'Application List')
@section('breadcrumb')
    @parent
    <li><a href="{{url('tenant/client')}}" title="All Clients"><i class="fa fa-users"></i> Clients</a></li>
    <li>View</li>
@stop
@section('content')

    <div class="container">
        <div class="box box-primary">
            <div class="col-sm-12">
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

                            @include('Tenant::ApplicationStatus/navbar')
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
                    <h3 class="box-title">List of Application on Enquiry</h3>
                </div>
                <div>
                     <form class="form-inline" action='' method="POST">
                        <div class="form-group">
                            <label for="filter">Filter By: </label>
                            <select name="filter"  class="form-control" id="filter">
                                <option value="name">Client Name</option>
                                <option value="instituteName">Institute Name</option>
                                <option value="courseName">Course Name</option>
                                <option value="subAgent">Sub Agent</option>
                                <option value="invoiceTo">Invoice To</option>
                            </select>
                        </div>  &nbsp;&nbsp;
                        <div class="form-group">
                            <label for="search">Search For: </label>
                            <input type="email" name="search" class="form-control" id="search" placeholder="">
                        </div>
                        <button type="submit" class="btn btn-success">Search</button>
                    </form>
                </div>
                <div class="box-body table-responsive">

                    <table id="applications" class="table table-bordered table-striped dataTable">
                        <thead>
                        <tr>
                            <th>Application ID</th>
                            <th>Client Name</th>
                            <th>Institute Name</th>
                            <th>Course Name</th>
                            <th>Start Date</th>
                            <th>Total Tuition Fee</th>
                            <th>Sub Agent</th>
                            <th>Invoice To</th>
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
