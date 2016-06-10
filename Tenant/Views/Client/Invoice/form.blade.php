<div class="box-body">
    <div class="col-md-6">

        <div class="form-group">
            {!!Form::label('course_application_id', 'Application *', array('class' => 'col-sm-4 control-label')) !!}
            <div class="col-sm-8">
                {!!Form::select('course_application_id', $applications, null, array('class' => 'form-control', 'id'=>'course_application_id'))!!}
            </div>
        </div>

        <div class="form-group @if($errors->has('invoice_date')) {{'has-error'}} @endif">
            {!!Form::label('invoice_date', 'Invoice Date *', array('class' => 'col-sm-4 control-label')) !!}
            <div class="col-sm-8">
                <div class="input-group date">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    {!!Form::text('invoice_date', null, array('class' => 'form-control', 'id'=>'invoice_date'))!!}
                </div>
                @if($errors->has('invoice_date'))
                    {!! $errors->first('invoice_date', '<label class="control-label"
                                                      for="inputError">:message</label>') !!}
                @endif
            </div>
        </div>

        <div class="form-group @if($errors->has('amount')) {{'has-error'}} @endif">
            {!!Form::label('amount', 'Amount *', array('class' => 'col-sm-4 control-label')) !!}
            <div class="col-sm-8">
                <div class="input-group">
                    <span class="input-group-addon">$</span>
                    {!!Form::text('amount', null, array('class' => 'form-control', 'id'=>'amount'))!!}
                </div>
                @if($errors->has('amount'))
                    {!! $errors->first('amount', '<label class="control-label"
                                                             for="inputError">:message</label>') !!}
                @endif
            </div>
        </div>

        <div class="form-group @if($errors->has('discount')) {{'has-error'}} @endif">
            {!!Form::label('discount', 'Discount *', array('class' => 'col-sm-4 control-label')) !!}
            <div class="col-sm-8">
                <div class="input-group">
                    <span class="input-group-addon">$</span>
                    {!!Form::text('discount', null, array('class' => 'form-control', 'id'=>'discount'))!!}
                </div>
                @if($errors->has('discount'))
                    {!! $errors->first('discount', '<label class="control-label"
                                                              for="inputError">:message</label>') !!}
                @endif
            </div>
        </div>

        <div class="form-group @if($errors->has('invoice_amount')) {{'has-error'}} @endif">
            {!!Form::label('invoice_amount', 'Invoice Amount *', array('class' => 'col-sm-4 control-label')) !!}
            <div class="col-sm-8">
                <div class="input-group">
                    <span class="input-group-addon">$</span>
                    {!!Form::text('invoice_amount', null, array('class' => 'form-control', 'id'=>'invoice_amount'))!!}
                </div>
                @if($errors->has('invoice_amount'))
                    {!! $errors->first('invoice_amount', '<label class="control-label"
                                                           for="inputError">:message</label>') !!}
                @endif
            </div>
        </div>

        <div class="form-group @if($errors->has('description')) {{'has-error'}} @endif">
            {!!Form::label('description', 'Description', array('class' => 'col-sm-4 control-label')) !!}
            <div class="col-sm-8">
                {!!Form::textarea('description', null, array('class' => 'form-control', 'id'=>'description'))!!}
                @if($errors->has('description'))
                    {!! $errors->first('description', '<label class="control-label"
                                                            for="inputError">:message</label>') !!}
                @endif
            </div>
        </div>

        <div class="form-group @if($errors->has('due_date')) {{'has-error'}} @endif">
            {!!Form::label('due_date', 'Due Date *', array('class' => 'col-sm-4 control-label')) !!}
            <div class="col-sm-8">
                <div class="input-group date">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    {!!Form::text('due_date', null, array('class' => 'form-control', 'id'=>'due_date'))!!}
                </div>
                @if($errors->has('due_date'))
                    {!! $errors->first('due_date', '<label class="control-label"
                                                      for="inputError">:message</label>') !!}
                @endif
            </div>
        </div>


    </div>
</div>


<script>
    $(function () {
        $("#invoice_date").datepicker({
            autoclose: true
        });

        $("#due_date").datepicker({
            autoclose: true
        });
    });
</script>