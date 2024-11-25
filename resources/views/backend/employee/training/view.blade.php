<p style="padding-left: 20px">
	Objektif Training / Kualifikasi	 : <strong>{{ $header->title }}</strong><br>
	Nama Trainer : <strong>{{ $header->trainer }}</strong><br>
	Tanggal Training : <strong>{{ $header->date }}</strong><br>
</p>
<table class="table table-sm table-striped table-bordered">
	<thead>
		<tr>
			<th class="text-center">NIK</th>
			<th class="text-center">Nama</th>
			<th class="text-center">Posisi</th>
			<th class="text-center">Status Belting</th>
			<th class="text-center">Cabang</th>
			<th class="text-center">Hasil</th>
			<th class="text-center">Review</th>
			<th class="text-center">Note</th>
			<th class="text-center">#</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($row as $item)
		<tr>
			<td class="text-center">{{ $item->employee->nik }}</td>
			<td>{{ $item->employee->name }}</td>
			<td class="text-center">{{ $item->jabatan->title }}</td>
			<td class="text-center">{{ $item->belting->title }}</td>
			<td class="text-center">{{ $item->lokasi->title }}</td>
			<td class="text-center">{{ $item->hasil }}</td>
			<td class="text-center">{{ $item->review }}</td>
			<td>{{ $item->note }}</td>
			<td class="text-center">
				<a href="javascript:void(0);" class="update" data-id="{{ $item->id }}">
					<span class="badge badge-info">Update</span>
				</a>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
<script type="text/javascript">
  $(document).ready(function(){
		var swalInit = swal.mixin({
			buttonsStyling: false,
			customClass: {
				confirmButton: 'btn btn-primary',
				cancelButton: 'btn btn-light',
				denyButton: 'btn btn-light',
				input: 'form-control'
			}
		});

    $(".update").click(function(e) {
      var id = $(this).data('id');
      var url = '{{ route('backend.employee.training.detail') }}';
			var token = '{{ csrf_token() }}';
      $.ajax({
        url: url,
        type: "POST",
        data : { id:id, _token:token },
        success: function (ajaxData){
          $("#modalEx").html(ajaxData);
          $("#modalEx").modal('show',{backdrop: 'true'});
        }
      });
    });
	});
</script>