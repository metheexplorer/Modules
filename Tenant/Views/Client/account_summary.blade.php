@extends('layouts.tenant')
@section('title', 'Client View')
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
              <img src="https://scontent-lax3-1.xx.fbcdn.net/v/t1.0-9/1936510_10207216981375364_4596889339024157957_n.jpg?oh=f3031e9add8769ca489e5865a54b6bc4&oe=57B0E02E" class="img-rounded" alt="Cinque Terre" width="150" height="150"> 
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
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <a class="navbar-brand visible-xs" href="#">AMS</a>
                        </div>

                        @include('Tenant::Client/navbar')
                    </div><!--/.container-fluid -->
                </nav>
          
            </div>


        </div>
        
      </div>
      
    <div class="col-md-3">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Payment Summary</h3>
                </div>
            
            <!-- /.box-header -->
                <div class="box-body">
                    <strong>
                        <i class="fa fa-calendar margin-r-5"></i>
                        Total Invoice Amount
                    </strong>
                    <p class="text-muted">20000</p>
                    <strong>
                        <i class="fa fa-calendar margin-r-5"></i>
                        Total Paid Amount
                    </strong>
                    <p class="text-muted">20000</p>
                    <strong>
                        <i class="fa fa-calendar margin-r-5"></i>
                        Due Amount
                    </strong>
                    <p class="text-muted">8000</p>
                </div>
            </div>
    </div>
    <div class="col-xs-9">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Recent Invoices</h3>
                <a href='{{url("tenant/invoice/".$client->client_id."/add")}}' class="btn btn-success btn-flat pull-right"><i class="glyphicon glyphicon-plus-sign"></i> Create Invoice</a>
            </div>
            <div class="box-body">
                <table id="invoices" class="table table-bordered table-striped dataTable">
                    <thead>
                    <tr>
                        <th>Invoice ID</th>
                        <th>Invoice Date</th>
                        <th>Description</th>
                        <th>Invoice Amount</th>
                        <th>Status</th>
                        <th>Outstanding Amount</th>
                        <th width="70px"></th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Recent Payments</h3>
                <a href="{{url("tenant/payment/".$client->client_id."/add")}}" class="btn btn-success btn-flat pull-right"><i class="glyphicon glyphicon-plus-sign"></i> Add Payments</a>
            </div>
            <div class="box-body">
                <table id="payments" class="table table-bordered table-striped dataTable">
                    <thead>
                    <tr>
                        <th>Payment ID</th>
                        <th>Payment Date</th>
                        <th>Amount</th>
                        <th>Paid By</th>
                        <th>Payment Type</th>
                        <th>Invoice Id</th>
                        <th>Description</th>
                        <th width="70px"></th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Future Invoices</h3>
                <button class="btn btn-success btn-flat pull-right"><i class="glyphicon glyphicon-plus-sign"></i> Create Invoice</button>
            </div>
            <div class="box-body">
                <table id="clients" class="table table-bordered table-striped dataTable">
                    <thead>
                    <tr>
                        <th>Invoice ID</th>
                        <th>Future Invoice Date</th>
                        <th>Description</th>
                        <th>Invoice Amount</th>
                        <th>Status</th>
                        <th>Outstanding Amount</th>
                        <th></th>

                    </tr>
                    <tr>
                        <td>I80001</td>
                        <td>12/06/2016</td>
                        
                        <td>College fee</td>
                        <td>2000</td>
                        <td>outstanding</td>
                        <td>5000 /view paymens)</td>
                        <td>Add payment  / view / edit / delete </td>

                    </tr>
                    </thead>
                </table>
            </div>


        </div>

         
    </div>
</div>

    <script type="text/javascript">
        $(document).ready(function () {
            oTable = $('#payments').DataTable({
                "processing": true,
                "serverSide": true,

                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": true,

                "ajax": appUrl + "/tenant/payments/client/"+ <?php echo $client->client_id ?> +"/data",
                "columns": [
                    {data: 'client_payment_id', name: 'client_payment_id'},
                    {data: 'date_paid', name: 'date_paid'},
                    {data: 'amount', name: 'amount'},
                    {data: 'payment_method', name: 'payment_method'},
                    {data: 'payment_type', name: 'payment_type'},
                    {data: 'invoice_id', name: 'invoice_id', orderable: false, searchable: false},
                    {data: 'description', name: 'description', orderable: false, searchable: false},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });

            iTable = $('#invoices').DataTable({
                "processing": true,
                "serverSide": true,

                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": true,

                "ajax": appUrl + "/tenant/invoices/client/"+ <?php echo $client->client_id ?> +"/data",
                "columns": [
                    {data: 'invoice_id', name: 'invoice_id'},
                    {data: 'invoice_date', name: 'invoice_date'},
                    {data: 'description', name: 'description', orderable: false, searchable: false},
                    {data: 'invoice_amount', name: 'invoice_amount'},
                    {data: 'status', name: 'status'},
                    {data: 'outstanding_amount', name: 'outstanding_amount'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
        });
    </script>

    
@stop