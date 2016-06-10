<div class="box-body">
    <div class="row">
        <div class="col-sm-6">
            <div class="col-md-12">
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

                <div class="form-group @if($errors->has('installment_no')) {{'has-error'}} @endif">
                    {!!Form::label('installment_no', 'Installment Number', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!!Form::text('installment_no', null, array('class' => 'form-control', 'id'=>'installment_no'))!!}
                        @if($errors->has('installment_no'))
                            {!! $errors->first('installment_no', '<label class="control-label"
                                                                    for="inputError">:message</label>') !!}
                        @endif
                    </div>
                </div>
                <div class="form-group @if($errors->has('installment_no')) {{'has-error'}} @endif">
                    {!!Form::label('description', 'Description', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        {!!Form::text('description', null, array('class' => 'form-control', 'id'=>'description'))!!}
                        @if($errors->has('description'))
                            {!! $errors->first('description', '<label class="control-label"
                                                                    for="inputError">:message</label>') !!}
                        @endif
                    </div>
                </div>

                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Tution Fee</h3>
                    </div>
                    <div class="form-group @if($errors->has('invoice_amount')) {{'has-error'}} @endif">
                        {!!Form::label('tution_fee', 'Tution Fee *', array('class' => 'col-sm-4 control-label')) !!}
                        <div class="col-sm-8">
                            <div class="input-group">
                                <span class="input-group-addon">$</span>
                                {!!Form::text('tution_fee', null, array('class' => 'form-control', 'id'=>'tution_fee'))!!}
                            </div>
                            @if($errors->has('tution_fee'))
                                {!! $errors->first('tution_fee', '<label class="control-label"
                                                                       for="inputError">:message</label>') !!}
                            @endif
                        </div>
                    </div>

                    <div class="form-group @if($errors->has('enrollment_fee')) {{'has-error'}} @endif">
                        {!!Form::label('enrollment_fee', 'Enrollment Fee *', array('class' => 'col-sm-4 control-label')) !!}
                        <div class="col-sm-8">
                            <div class="input-group">
                                <span class="input-group-addon">$</span>
                                {!!Form::text('enrollment_fee', 0, array('class' => 'form-control', 'id'=>'enrollment_fee',))!!}
                            </div>
                            @if($errors->has('enrollment_fee'))
                                {!! $errors->first('enrollment_fee', '<label class="control-label"
                                                                         for="inputError">:message</label>') !!}
                            @endif
                        </div>
                    </div>

                    <div class="form-group @if($errors->has('material_fee')) {{'has-error'}} @endif">
                        {!!Form::label('material_fee', 'Material Fee *', array('class' => 'col-sm-4 control-label')) !!}
                        <div class="col-sm-8">
                            <div class="input-group">
                                <span class="input-group-addon">$</span>
                                {!!Form::text('material_fee', 0, array('class' => 'form-control', 'id'=>'material_fee'))!!}
                            </div>
                            @if($errors->has('material_fee'))
                                {!! $errors->first('material_fee', '<label class="control-label"
                                                                         for="inputError">:message</label>') !!}
                            @endif
                        </div>
                    </div>

                    <div class="form-group @if($errors->has('coe_fee')) {{'has-error'}} @endif">
                        {!!Form::label('coe_fee', 'COE Fee *', array('class' => 'col-sm-4 control-label')) !!}
                        <div class="col-sm-8">
                            <div class="input-group">
                                <span class="input-group-addon">$</span>
                                {!!Form::text('coe_fee', 0, array('class' => 'form-control', 'id'=>'coe_fee'))!!}
                            </div>
                            @if($errors->has('coe_fee'))
                                {!! $errors->first('coe_fee', '<label class="control-label"
                                                                         for="inputError">:message</label>') !!}
                            @endif
                        </div>
                    </div>

                    <div class="form-group @if($errors->has('other_fee')) {{'has-error'}} @endif">
                        {!!Form::label('other_fee', 'Other Fee*', array('class' => 'col-sm-4 control-label')) !!}
                        <div class="col-sm-8">
                            <div class="input-group">
                                <span class="input-group-addon">$</span>
                                {!!Form::text('other_fee', 0, array('class' => 'form-control', 'id'=>'other_fee'))!!}
                            </div>
                            @if($errors->has('other_fee'))
                                {!! $errors->first('other_fee', '<label class="control-label"
                                                                         for="inputError">:message</label>') !!}
                            @endif
                        </div>
                    </div>

                    <div class="form-group @if($errors->has('sub_total')) {{'has-error'}} @endif">
                        {!!Form::label('sub_total', 'Sub Total *', array('class' => 'col-sm-4 control-label')) !!}
                        <div class="col-sm-8">
                            <div class="input-group">
                                <span class="input-group-addon">$</span>
                                {!!Form::text('sub_total', null, array('class' => 'form-control', 'id'=>'sub_total','placeholder'=>'click to calculate'))!!}
                            </div>
                            @if($errors->has('sub_total'))
                                {!! $errors->first('sub_total', '<label class="control-label"
                                                                         for="inputError">:message</label>') !!}
                            @endif
                        </div>
                    </div>
                    <hr>

                <div class="form-group @if($errors->has('commission_percent')) {{'has-error'}} @endif">
                        {!!Form::label('commission_percent', 'Commission Percent *', array('class' => 'col-sm-4 control-label')) !!}
                        <div class="col-sm-8">
                            <div class="input-group">
                                <span class="input-group-addon">$</span>
                                {!!Form::text('commission_percent', null, array('class' => 'form-control', 'id'=>'commission_percent'))!!}
                            </div>
                            @if($errors->has('commission_percent'))
                                {!! $errors->first('commission_percent', '<label class="control-label"
                                                                         for="inputError">:message</label>') !!}
                            @endif
                        </div>
                    </div>

                    <div class="form-group @if($errors->has('commission_amount')) {{'has-error'}} @endif">
                        {!!Form::label('commission_amount', 'Commission Amount *', array('class' => 'col-sm-4 control-label')) !!}
                        <div class="col-sm-8">
                            <div class="input-group">
                                <span class="input-group-addon">$</span>
                                {!!Form::text('commission_amount', null, array('class' => 'form-control', 'id'=>'commission_amount','placeholder'=>'click to calculate'))!!}
                            </div>
                            @if($errors->has('commission_amount'))
                                {!! $errors->first('commission_amount', '<label class="control-label"
                                                                         for="inputError">:message</label>') !!}
                            @endif
                        </div>
                    </div>
                    <div class="form-group @if($errors->has('gst')) {{'has-error'}} @endif">
                        {!!Form::label('gst', 'Commission GST *', array('class' => 'col-sm-4 control-label')) !!}
                        <div class="col-sm-8">
                            <div class="input-group">
                                <span class="input-group-addon">$</span>
                                {!!Form::text('gst', null, array('class' => 'form-control', 'id'=>'gst','placeholder'=>'click to calculate'))!!}
                            </div>
                            @if($errors->has('gst'))
                                {!! $errors->first('gst', '<label class="control-label"
                                                                         for="inputError">:message</label>') !!}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
            <div class="col-sm-6">
                
            
            <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Other Commission</h3>
                    </div>
                <div class="form-group @if($errors->has('incentive')) {{'has-error'}} @endif">
                    {!!Form::label('incentive', 'Incentive *', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            {!!Form::text('incentive', null, array('class' => 'form-control', 'id'=>'incentive'))!!}
                        </div>
                        @if($errors->has('incentive'))
                            {!! $errors->first('incentive', '<label class="control-label"
                                                                     for="inputError">:message</label>') !!}
                        @endif
                    </div>
                </div>

                <div class="form-group @if($errors->has('gst')) {{'has-error'}} @endif">
                    {!!Form::label('gst', 'Incentive GST *', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            {!!Form::text('gst', null, array('class' => 'form-control', 'id'=>'gst','placeholder'=>'click to calculate'))!!}
                        </div>
                        @if($errors->has('gst'))
                            {!! $errors->first('gst', '<label class="control-label"
                                                                     for="inputError">:message</label>') !!}
                        @endif
                    </div>
                </div>
            </div>

            <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Total Amount</h3>
                    </div>
                <div class="form-group @if($errors->has('total_commission')) {{'has-error'}} @endif">
                    {!!Form::label('total_commission', 'Total Amount *', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            {!!Form::text('total_commission', null, array('class' => 'form-control', 'id'=>'total_commission','placeholder'=>'click to calculate'))!!}
                        </div>
                        @if($errors->has('total_commission'))
                            {!! $errors->first('total_commission', '<label class="control-label"
                                                                     for="inputError">:message</label>') !!}
                        @endif
                    </div>
                </div>

                <div class="form-group @if($errors->has('total_gst')) {{'has-error'}} @endif">
                    {!!Form::label('total_gst', 'Total GST *', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            {!!Form::text('total_gst', null, array('class' => 'form-control', 'id'=>'total_gst','placeholder'=>'click to calculate'))!!}
                        </div>
                        @if($errors->has('total_gst'))
                            {!! $errors->first('total_gst', '<label class="control-label"
                                                                     for="inputError">:message</label>') !!}
                        @endif
                    </div>
                </div>
                <div class="form-group @if($errors->has('payable_to_college')) {{'has-error'}} @endif">
                    {!!Form::label('payable_to_college', 'Payable To College *', array('class' => 'col-sm-4 control-label')) !!}
                    <div class="col-sm-8">
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            {!!Form::text('payable_to_college', null, array('class' => 'form-control', 'id'=>'payable_to_college','placeholder'=>'click to calculate'))!!}
                        </div>
                        @if($errors->has('payable_to_college'))
                            {!! $errors->first('payable_to_college', '<label class="control-label"
                                                              for="inputError">:message</label>') !!}
                        @endif
                    </div>
                </div>
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