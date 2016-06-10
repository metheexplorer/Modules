@extends('layouts.tenant')
@section('title', 'Client View')
@section('breadcrumb')
    @parent
    <li><a href="{{url('tenant/application')}}" title="All Applications"><i class="fa fa-users"></i> Applications</a>
    </li>
    <li>View</li>
@stop
@section('content')

    @include('Tenant::Client/Application/navbar')

    <div class="content">

        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title"> &nbsp;Application -
                    <small>View</small>
                </h3>
            </div>

            <div class="box-body">
                <div class="row">
                    <div class="col-sm-9">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Course Information</h3>
                            </div>
                            <div class="panel-body">
                                <a href="#" class="pull-right">Edit</a>

                                <p>Course Enrolled<br/>
                                    {{ $application->course_name }}<br/>
                                    Institute<br/>
                                    {{ $application->company_name }}<br/>
                                    From {{ format_date($application->intake_date) }}
                                    to {{ format_date($application->end_date) }}<br/>
                                    Student ID: {{ format_id($application->student_id, 'Std') }}</p>
                            </div>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Payment to College</h3>
                                <a href="{{ route('tenant.application.payment', $application->application_id) }}" class="btn btn-primary btn-flat pull-right"><i class="glyphicon glyphicon-plus-sign"></i> Add Payment</a>
                            </div>
                            <div class="panel-body">
                                <table class="table table-striped table-bordered">
                                    <tr>
                                        <td>Total Fee</td>
                                        <td>25000</td>
                                    </tr>
                                    <tr>
                                        <td>Total Paid</td>
                                        <td>15000</td>
                                    </tr>
                                    <tr>
                                        <td>Total Remaining</td>
                                        <td>10000</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Commission Details</h3>
                            </div>
                            <div class="panel-body">
                                <table class="table table-striped table-bordered">
                                    <tr>
                                        <td>Commission Payable Amout</td>
                                        <td>25000</td>
                                    </tr>
                                    <tr>
                                        <td>Total Commission Claimed</td>
                                        <td>15000</td>
                                    </tr>
                                    <tr>
                                        <td>Remaining Commission</td>
                                        <td>10000</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                    </div>

                    <div class="col-sm-3">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Status</h3>
                            </div>
                            <div class="panel-body">
                                <div class="well well-sm">
                                    Enrolled
                                    <a href="#" class="pull-right">modify</a>
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Super Agent</h3>
                            </div>
                            <div class="panel-body">
                                <div class="well well-sm">
                                    @if($application->super_agent_id != null)
                                        {{ get_agent_name($application->super_agent_id) }}
                                        <a href="#" class="pull-right">view</a>
                                    @else
                                        None
                                        <button class="btn btn-primary btn-xs pull-right" data-toggle="modal"
                                                data-target="#agentModal"><i class="glyphicon glyphicon-plus-sign"></i>
                                            Add
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Sub Agent</h3>
                            </div>
                            <div class="panel-body">
                                <div class="well well-sm">
                                    @if($application->sub_agent_id != null)
                                        {{ get_agent_name($application->sub_agent_id) }}
                                        <a href="#" class="pull-right">view</a>
                                    @else
                                        None
                                        <button class="btn btn-primary btn-xs pull-right" data-toggle="modal"
                                                data-target="#agentModal"><i class="glyphicon glyphicon-plus-sign"></i>
                                            Add
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Student owing Agency</h3>
                            </div>
                            <div class="panel-body">
                                <h3>$500</h3>
                            </div>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Pending Active Commission</h3>
                            </div>
                            <div class="panel-body">
                                <h3>$450</h3>
                            </div>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Uninvoice Amount</h3>
                            </div>
                            <div class="panel-body">
                                <h3>$700</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="agentModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-sm">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Sub Agent</h4>
                </div>
                {!!Form::open(['url' => 'tenant/applications/'.$application->application_id.'/subagent', 'id' => 'add-agent', 'class' => 'form-horizontal form-left'])!!}
                <div class="modal-body">

                    <div class="form-group">
                        {!!Form::label('agent_id', 'Agent *', array('class' => 'col-sm-4 control-label')) !!}
                        <div class="col-sm-8">
                            {!!Form::select('agent_id', $agents, null, array('class' => 'form-control', 'id'=>'agent_id'))!!}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success"><i class="fa fa-plus-circle"></i>
                        Add
                    </button>
                </div>
                {!!Form::close()!!}
            </div>

        </div>
    </div>

@stop
