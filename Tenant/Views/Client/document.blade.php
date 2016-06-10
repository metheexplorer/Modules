@extends('layouts.tenant')
@section('title', 'Client Documents')
@section('breadcrumb')
    @parent
    <li><a href="{{url('client')}}" title="All Clients"><i class="fa fa-users"></i> Clients</a></li>
    <li><i class="fa fa-file"></i> Documents</li>
@stop
@section('content')

    <div class="container">
        <div class="row">

            <div class="col-sm-2">
                <div class="container">
                    {!! Form::open(array('id' => 'image-form', 'files' => true)) !!}
                        {!!Form::file('profile-image', array('id' => 'profile-image-upload', 'class' => 'hide'))!!}
                        <div id="profile-image">
                            <img src="https://scontent-lax3-1.xx.fbcdn.net/v/t1.0-9/1936510_10207216981375364_4596889339024157957_n.jpg?oh=f3031e9add8769ca489e5865a54b6bc4&oe=57B0E02E"
                             class="img-rounded" alt="Cinque Terre" width="150" height="150">
                        </div>
                    {!! Form::close() !!}
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
    </div>

    <div class="pad margin no-print">
        <div class="callout callout-info" style="margin-bottom: 0!important;">
            <h4><i class="fa fa-info"></i> Note:</h4>
            The supported mime types for the documents are Images, Word, TXT, PDF and Excel files.
        </div>
    </div>
    <div class="col-xs-12 mainContainer">
        @include('flash::message')

        <div class="col-md-4 col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Upload File</h3>
                </div>

                <div class="box-body">
                    {!! Form::open(['files' => true, 'method' => 'post']) !!}
                    <div class="form-group @if($errors->has('type')) {{'has-error'}} @endif">
                        {!!Form::label('type', 'Document Type *', array('class' => '')) !!}
                        {!!Form::text('type', null, array('class' => 'form-control'))!!}
                        @if($errors->has('type'))
                            {!! $errors->first('type', '<label class="control-label"
                                                               for="inputError">:message</label>') !!}
                        @endif
                    </div>
                    <div class="form-group @if($errors->has('description')) {{'has-error'}} @endif">
                        {!!Form::label('description', 'Description *', array('class' => '')) !!}
                        {!!Form::textarea('description', null, array('class' => 'form-control'))!!}
                        @if($errors->has('description'))
                            {!! $errors->first('description', '<label class="control-label"
                                                                      for="inputError">:message</label>') !!}
                        @endif
                    </div>
                    <div class="form-group @if($errors->has('document')) {{'has-error'}} @endif">
                        {!!Form::label('document', 'File *', array('class' => '')) !!}
                        {!!Form::file('document', null, array('class' => 'form-control'))!!}
                        @if($errors->has('document'))
                            {!! $errors->first('document', '<label class="control-label"
                                                                   for="inputError">:message</label>') !!}
                        @endif
                    </div>

                    <div class="form-group pull-right clearfix">
                        {!! Form::submit('Upload', ['class' => "btn btn-primary"]) !!}
                    </div>
                    {!! Form::close() !!}

                    <div class="clearfix"></div>
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-8 col-xs-12">
            <div class="box box-primary">
                <div class="box-body table-responsive">
                    <h3 class="text-center">Uploaded Files</h3>
                    <hr/>
                    @if(count($documents) > 0)
                    <table id="table-lead" class="table table-hover">
                        <thead>
                        <tr>
                            <th>Uploaded On</th>
                            <th>Uploaded By</th>
                            <th>Filename</th>
                            <th>Document Type</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($documents as $key => $document)
                            <tr>
                                <td>{{format_datetime($document->document->created_at)}}</td>
                                <td>{{ get_tenant_name($document->document->user_id) }}</td>
                                <td>{{ $document->document->name }}</td>
                                <td>{{ $document->document->type }}</td>
                                <td>{{ $document->document->description }}</td>
                                <td><a href="{{ $document->document->shelf_location }}"
                                       target="_blank"><i class="fa fa-eye"></i> View</a>
                                    <a href="{{route('tenant.client.document.download', $document->document_id)}}"
                                       target="_blank"><i class="fa fa-download"></i> Download</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @else
                        <p class="text-muted well">
                            No documents uploaded yet.
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    {!! Condat::js('client/document.js'); !!}
    <script type="text/javascript">
        $(function() {
            $('#profile-image').on('click', function() {
                $('#profile-image-upload').click();
            });
        });
    </script>
@stop
