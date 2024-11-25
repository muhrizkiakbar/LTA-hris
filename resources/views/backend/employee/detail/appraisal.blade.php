<div class="modal-dialog">
  <div class="modal-content">
		<div class="modal-header">
			<h6 class="modal-title" id="myLargeModalLabel">Generate Performance Appraisal</h6>
		</div>
    <div class="modal-body">
      <fieldset>
        {!! Form::open(['route'=>['backend.employee.appraisal.store'],'method'=>'POST','files' => true]) !!}
        <div class="form-group row">
          <div class="col-md-2"><label class="col-form-label">Periode</label></div>
          <div class="col-md-4">{!! Form::text('date_start',null,['class'=>'form-control datepick','data-language'=>'en','data-min-view'=>'months','data-view'=>'months','data-date-format'=>'MM yyyy']) !!}</div>
          <div class="col-md-4">{!! Form::text('date_end',null,['class'=>'form-control datepick','data-language'=>'en','data-min-view'=>'months','data-view'=>'months','data-date-format'=>'MM yyyy']) !!}</div>
        </div>
        <div class="form-group row">
          <label class="col-form-label col-md-2"></label>
          <div class="col-md-6">
            <button class="btn btn-info btn-sm" type="submit">Generate</button>
            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
          </div>
        </div>
        {!! Form::hidden('user_id',$id) !!}
        {!! Form::close() !!}
      </fieldset>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function(){
    $(".select2").select2();
    $('.datepick').datepicker({
    	autoClose:true
    });
  });
</script>