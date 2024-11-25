<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-body">
      <fieldset>
        <legend class="text-uppercase font-size-sm font-weight-bold">Detail Training & Belting </legend>
        <table border="0" width="100%">
          <tr>
            <th width="170px" class="text-left">Nama Training</th>
            <td width="10px" class="text-center">:</td>
            <td>{{ $data->training->title }}</td>
          </tr>
          <tr>
            <th class="text-left">Kualifikasi</th>
            <td class="text-center">:</td>
            <td>{{ $data->training->klasifikasi->title }}</td>
          </tr>
          <tr>
            <th class="text-left">Tanggal Training</th>
            <td class="text-center">:</td>
            <td>{{ $data->training->date }}</td>
          </tr>
          <tr>
            <th class="text-left">Nama Trainer</th>
            <td class="text-center">:</td>
            <td>{{ $data->training->trainer }}</td>
          </tr>
          <tr>
            <th class="text-left">Nama Karyawan</th>
            <td class="text-center">:</td>
            <td>{{ $data->employee->name }}</td>
          </tr>
          <tr>
            <th class="text-left">Posisi</th>
            <td class="text-center">:</td>
            <td>{{ empty($data->department_jabatan) ? '-' : $data->jabatan->title }}</td>
          </tr>
        </table>
        {!! Form::model($data,['route'=>['backend.employee.training.update',$data->id],'method'=>'PUT']) !!}
        @if ($data->training->klasifikasi_training_id != 6)
        <div class="form-group row">
          <div class="col-md-4"><label class="col-form-label">Pencapaian Belting</label></div>
          <div class="col-md-6">{!! Form::select('belting_id',$belting,null,['class'=>'form-control select2','placeholder'=>'-- Status Belting --']) !!}</div>
        </div>   
        @endif
        <div class="form-group row">
          <div class="col-md-4"><label class="col-form-label">Hasil</label></div>
          <div class="col-md-8">{!! Form::text('hasil',null,['class'=>'form-control']) !!}</div>
        </div>
        <div class="form-group row">
          <div class="col-md-4"><label class="col-form-label">Review</label></div>
          <div class="col-md-8">{!! Form::textarea('review',null,['class'=>'form-control','rows'=>4]) !!}</div>
        </div>
        <div class="form-group row">
          <div class="col-md-4"><label class="col-form-label">Note</label></div>
          <div class="col-md-8">{!! Form::textarea('note',null,['class'=>'form-control','rows'=>3]) !!}</div>
        </div>
        <div class="form-group row">
          <label class="col-form-label col-md-4"></label>
          <div class="col-md-6">
            <button class="btn btn-info btn-sm" type="submit">Update</button>
            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
          </div>
        </div>
        {!! Form::close() !!}
      </fieldset>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function(){
    $(".select2").select2({
			width: '100%'
		});

    $('.datepick').datepicker({
    	autoClose:true
    });

  });
</script>