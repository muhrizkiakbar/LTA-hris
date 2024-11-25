<div class="modal-dialog modal-md">
  <div class="modal-content">
		<div class="modal-header">
			<h6 class="modal-title" id="myLargeModalLabel">{{ $title }}</h6>
		</div>
    <div class="modal-body">
			{!! Form::open(['route'=>['backend.users.lokasi_update'],'method'=>'POST','files' => true]) !!}
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Lokasi</label></div>
				<div class="col-md-8">{!! Form::select('lokasi_id',$lokasi,NULL,['class'=>'form-control','placeholder'=>'-- Lokasi --']) !!}</div>
			</div>
			<input type="hidden" name="users_id" value="{{ $id }}">
			<div class="form-group row">
				<div class="col-md-3"></div>
				<div class="col-md-9">
					<button class="btn btn-primary btn-sm" type="submit">Update</button>
					<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
				</div>
			</div>
			{!! Form::close() !!}

			<table class="table table-sm table-hovered table-striped table-bordered">
        <thead>
          <tr>
            <th class="text-center" width="1px">No</th>
            <th class="text-center">Lokasi</th>
            <th class="text-center" width="100px">#</th>
          </tr>
        </thead>
        <tbody>
          @php $no=1; @endphp
          @foreach ($row as $item)
          <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $item->lokasi->title }}</td>
            <td class="text-center">
              <a href="{{ route('backend.users.lokasi_delete',$item->id) }}" onclick="return confirm('Anda yakin ingin menghapus ?')">
                <span class="badge badge-danger">Delete</span>
              </a>
            </td>
          </tr>    
          @endforeach
        </tbody>
      </table>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
    $(".select2").select2({
			width: '100%'
		});

    $("#tglExtend").datepicker({
      multidate: true,
      minDate: 0,
      weekStart: 1,
      orientation: 'bottom',
      clearButton : true
    });

    $("#tglExtend").datepicker('show');
  });
</script>