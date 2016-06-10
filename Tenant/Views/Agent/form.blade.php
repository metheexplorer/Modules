<div class="box-body">
    <div class="col-md-6">
        <div class="">
            Company Details

            <div class="">
                <div class="form-group @if($errors->has('short_name')) {{'has-error'}} @endif">
                    {!!Form::label('short_name', 'Short Name', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!!Form::text('short_name', null, array('class' => 'form-control', 'id'=>'short_name'))!!}
                        @if($errors->has('short_name'))
                            {!! $errors->first('short_name', '<label class="control-label"
                                                                     for="inputError">:message</label>') !!}
                        @endif
                    </div>
                </div>

                <div class="form-group @if($errors->has('name')) {{'has-error'}} @endif">
                    {!!Form::label('name', 'Company Name *', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!!Form::text('name', null, array('class' => 'form-control', 'id'=>'name'))!!}
                        @if($errors->has('name'))
                            {!! $errors->first('name', '<label class="control-label"
                                                               for="inputError">:message</label>') !!}
                        @endif
                    </div>
                </div>


                <div class="form-group @if($errors->has('number')) {{'has-error'}} @endif">
                    {!!Form::label('number', 'Phone Number *', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-phone"></i>
                            </div>
                            {!!Form::text('number', null, array('class' => 'form-control phone-input', 'id'=>'phone'))!!}
                        </div>
                        @if($errors->has('number'))
                            {!! $errors->first('number', '<label class="control-label"
                                                                for="inputError">:message</label>') !!}
                        @endif
                    </div>
                </div>

                <div class="form-group @if($errors->has('abn')) {{'has-error'}} @endif">
                    {!!Form::label('abn', 'ABN', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!!Form::text('abn', null, array('class' => 'form-control', 'id'=>'abn'))!!}
                        @if($errors->has('abn'))
                            {!! $errors->first('abn', '<label class="control-label"
                                                              for="inputError">:message</label>') !!}
                        @endif
                    </div>
                </div>

                <div class="form-group @if($errors->has('acn')) {{'has-error'}} @endif">
                    {!!Form::label('acn', 'ACN', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!!Form::text('acn', null, array('class' => 'form-control', 'id'=>'acn'))!!}
                        @if($errors->has('acn'))
                            {!! $errors->first('acn', '<label class="control-label"
                                                              for="inputError">:message</label>') !!}
                        @endif
                    </div>
                </div>

                <div class="form-group @if($errors->has('website')) {{'has-error'}} @endif">
                    {!!Form::label('website', 'Website', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!!Form::text('website', null, array('class' => 'form-control', 'id'=>'website'))!!}
                        @if($errors->has('website'))
                            {!! $errors->first('website', '<label class="control-label"
                                                                  for="inputError">:message</label>') !!}
                        @endif
                    </div>
                </div>

                <div class="form-group @if($errors->has('invoice_to_name')) {{'has-error'}} @endif">
                    {!!Form::label('invoice_to_name', 'Invoice To Whom', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!!Form::text('invoice_to_name', null, array('class' => 'form-control', 'id'=>'invoice_to_name'))!!}
                        @if($errors->has('invoice_to_name'))
                            {!! $errors->first('invoice_to_name', '<label class="control-label"
                                                                          for="inputError">:message</label>') !!}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        {{--Adresses--}}
        <div class="">
            Address Details
            <!-- /.box-header -->
            <div class="">
                <div class="form-group @if($errors->has('street')) {{'has-error'}} @endif">
                    {!!Form::label('street', 'Street', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!!Form::text('street', null, array('class' => 'form-control', 'id'=>'street'))!!}
                        @if($errors->has('street'))
                            {!! $errors->first('street', '<label class="control-label"
                                                                 for="inputError">:message</label>')
                            !!}
                        @endif
                    </div>
                </div>
                <div class="form-group @if($errors->has('suburb')) {{'has-error'}} @endif">
                    {!!Form::label('suburb', 'Suburb', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!!Form::text('suburb', null, array('class' => 'form-control', 'id'=>'suburb'))!!}
                        @if($errors->has('suburb'))
                            {!! $errors->first('suburb', '<label class="control-label"
                                                                 for="inputError">:message</label>')
                            !!}
                        @endif
                    </div>
                </div>
                <div class="form-group @if($errors->has('state')) {{'has-error'}} @endif">
                    {!!Form::label('state', 'State', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!!Form::text('state', null, array('class' => 'form-control', 'id'=>'state'))!!}
                        @if($errors->has('state'))
                            {!! $errors->first('state', '<label class="control-label"
                                                                for="inputError">:message</label>')
                            !!}
                        @endif
                    </div>
                </div>
                <div class="form-group @if($errors->has('postcode')) {{'has-error'}} @endif">
                    {!!Form::label('postcode', 'Postcode', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!!Form::text('postcode', null, array('class' => 'form-control', 'id'=>'postcode'))!!}
                        @if($errors->has('postcode'))
                            {!! $errors->first('postcode', '<label class="control-label"
                                                                   for="inputError">:message</label>')
                            !!}
                        @endif
                    </div>
                </div>

                <div class="form-group @if($errors->has('country_id')) {{'has-error'}} @endif">
                    {!!Form::label('country_id', 'Country', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!!Form::select('country_id', $countries, null, array('class' =>
                        'form-control'))!!}
                        @if($errors->has('country_id'))
                            {!! $errors->first('country_id', '<label class="control-label"
                                                                     for="inputError">:message</label>')
                            !!}
                        @endif
                    </div>
                </div>
            </div>
            <!-- /.box -->
        </div>
        <!--/.col (right) -->
    </div>

    <div class="col-md-12">
        <div class="form-group @if($errors->has('description')) {{'has-error'}} @endif">
            {!!Form::label('description', 'Agent Description', array('class' => 'col-sm-2 control-label')) !!}
            <div class="col-sm-8">
                {!!Form::textarea('description', null, array('class' => 'form-control'))!!}
                @if($errors->has('description'))
                    {!! $errors->first('country_id', '<label class="control-label"
                                                             for="inputError">:message</label>')
                    !!}
                @endif
            </div>
        </div>
    </div>
</div>