<?php $current = Request::segment(4); ?>
<div class="container">
    <div class="row">
        <div class="client-navbar" style="display: none;">
            <div class="col-sm-12 col-md-2">
                <div class="container">
                    <img src="https://scontent-lax3-1.xx.fbcdn.net/v/t1.0-9/1936510_10207216981375364_4596889339024157957_n.jpg?oh=f3031e9add8769ca489e5865a54b6bc4&oe=57B0E02E"
                         class="img-rounded" alt="Cinque Terre" width="150" height="150">
                </div>
            </div>
            <div class="col-sm-12 col-md-10">
                <div class="row">

                    <h4>{{$client->first_name}} {{$client->middle_name}} <b>{{$client->last_name}}</b></h4>

                    <p>University of Western Sydney</p>

                    <p>
                        Graduate Diploma of Professional Accounting
                    </p>
                </div>
                <div class="row">
                    <div id="navbar" class="navbar-collapse collapse">
                        <ul class="nav navbar-nav">
                            <li><a href={{url("tenant/clients/$application->client_id")}}>Dashboard</a></li>
                            <li><a href={{url("tenant/clients/$application->client_id/personal_details")}}>Personal
                                    Details</a></li>
                            <li class="active"><a href={{url("tenant/clients/$application->client_id/applications")}}>College
                                    Application</a></li>
                            <li><a href={{url("tenant/clients/$application->client_id/accounts")}}>Accounts</a></li>
                            <li><a href={{url("tenant/clients/$application->client_id/document")}}>Documents</a></li>
                            <li><a href={{url("tenant/clients/$application->client_id/notes")}}>Notes</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <span class="btn btn-success btn-small btn-flat menu-toggle">Toggle Client Menu</span>
    </div>
    <div class="row">
        {{--<div class="menu-opener">
            <span class="menu-opener-inner"></span>
        </div>--}}
    </div>

    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#navbar"
                        aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand visible-xs" href="#">AMS</a>
            </div>

            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li class="{{($current == 'show')? 'active' : ''}}"><a href="#">Dashboard</a></li>
                    <li><a href="#">Application Details</a></li>
                    <li class="{{($current == 'college')? 'active' : ''}}"><a href="{{route('tenant.application.college', $application->application_id)}}">College Accounts</a></li>
                    <li class="{{($current == 'students')? 'active' : ''}}"><a href="{{route('tenant.application.students', $application->application_id)}}">Students Accounts</a></li>
                    <li><a href="#">Sub Agent Payments</a></li>
                    <li><a href="#">Documents</a></li>
                    <li><a href="#">Notes</a></li>
                </ul>
            </div>
            <!--/.nav-collapse -->

        </div>
        <!--/.container-fluid -->
    </nav>
</div>

<script class="cssdeck" type="text/javascript">
    /*$(".menu-opener").click(function () {
        $(".menu-opener").toggleClass("active");
        $(".client-navbar, .menu-opener-inner").slideToggle();
    });*/

    $(".menu-toggle").click(function () {
        $(".client-navbar").slideToggle();
    });
</script>