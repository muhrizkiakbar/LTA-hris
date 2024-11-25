<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-body">
      <fieldset>
        <legend class="text-uppercase font-size-sm font-weight-bold">Tanda Tangan Karyawan</legend>
				{!! Form::open(['route'=>'backend.employee.sign_update','method'=>'POST','files' => true]) !!}
        <div class="form-group row">
          <div class="col-md-3"><label class="col-form-label">Tanda Tangan</label></div>
          <div class="col-md-6">
            {!! $ttd_url !!}
            <div class="mt-2">
              {!! Form::file('sign_file') !!}
            </div>
          </div>
        </div>
				<input type="hidden" name="id" value="{{ $get->id }}">
        <div class="form-group row">
          <label class="col-form-label col-md-3"></label>
          <div class="col-md-6">
            <button class="btn btn-primary btn-sm" type="submit">Update Tanda Tangan</button>
            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
          </div>
        </div>
        {!! Form::close() !!}
      </fieldset>
    </div>
  </div>
</div>