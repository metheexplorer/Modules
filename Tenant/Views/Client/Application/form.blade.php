<div class="form-group">
    {!!Form::label('institute_id', 'Select Institute', array('class' => 'col-md-2 col-sm-12 control-label')) !!}
    <div class="col-md-10 col-sm-12">
        {!!Form::select('institute_id', $institutes, null, array('class' => 'form-control', 'id' => 'institute'))!!}
        <a href="#" data-toggle="modal" data-target="#institute-modal">Add Institute</a>
    </div>
</div>

<div class="form-group">
    {!!Form::label('institution_course_id', 'Select Course', array('class' => 'col-md-2 col-sm-12 control-label')) !!}
    <div class="col-md-10 col-sm-12">
        {!!Form::select('institution_course_id', $courses, null, array('class' => 'form-control', 'id' => 'course'))!!}
        <a href="#" data-toggle="modal" data-target="#course-modal">Add Course</a>
    </div>
</div>

<div class="form-group">
    <label for="intake" class="col-sm-2 control-label">Select Intake</label>

    <div class="col-sm-10">
        {!!Form::select('intake_id', $intakes, null, array('class' =>
       'form-control', 'id' => 'intake'))!!}
        {{--<select name="intake" class="form-control" id="intake">
            <option value="1">Jan-Feb</option>
            <option value="1">Intake 2</option>
            <option value="3">Intake 3</option>
        </select>--}}
        <a href="#" data-toggle="modal" data-target="#intake-modal">Add Intake</a>
    </div>
</div>
<div class="form-group">
    <label for="end_date" class="col-sm-2 control-label">Finish Date</label>

    <div class="col-sm-10">
        <div class='input-group date'>
            <input type="text" name="end_date" class="form-control datepicker" id="end_date"
                   placeholder="yyyy-mm-dd">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
        </div>
    </div>
</div>
<div class="form-group">
    <label for="tuition_fee" class="col-sm-2 control-label">Tuition Fee</label>

    <div class="col-sm-10">
        <input type="text" name="tuition_fee" class="form-control" id="fee" placeholder="Tuition Fee">
    </div>
</div>
<div class="form-group">
    <label for="student_id" class="col-sm-2 control-label">Student ID</label>

    <div class="col-sm-10">
        <input type="text" name="student_id" class="form-control" id="student_id" placeholder="Student ID">
    </div>
</div>
<div class="form-group">
    <label for="super_agent_id" class="col-sm-2 control-label">Add Super Agent</label>

    <div class="col-sm-10">
        <input type="text" name="super_agent_id" class="form-control" id="super_agent_id" placeholder="Super Agent">
    </div>
</div>
<div class="form-group">
    <label for="sub_agent_id" class="col-sm-2 control-label">Add Sub Agent</label>

    <div class="col-sm-10">
        <input type="text" name="sub_agent_id" class="form-control" id="sub_agent_id" placeholder="Sub Agent">
    </div>
</div>

<script type="text/javascript">
    $("#institute").change(function () {
        getCourses();
        getIntakes();
    });

    function getCourses() {
        var institute = $("#institute").val();
        $.ajax({
            url: appUrl + "/tenant/courses/" + institute,
            success: function (result) {
                $("#course").html(result.data.options);
            }
        });
    }

    function getIntakes() {
        var institute = $("#institute").val();
        $.ajax({
            url: appUrl + "/tenant/intakes/" + institute,
            success: function (result) {
                $("#intake").html(result.data.options);
            }
        });
    }

    $(document).ready(function () {
        getCourses();
        getIntakes();
    })

</script>
{{ Condat::js("$('.datepicker').datepicker({
                startDate: '+0d',
                autoclose: true
            });"
            )
}}