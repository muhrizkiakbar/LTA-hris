<table class="table table-xs table-striped table-borderless">
	<thead>
		<tr>
			<th class="text-center">Kode Sloting</th>
			<th class="text-center">Nama</th>
			<th class="text-center">Jabatan</th>
			<th class="text-center">Cabang</th>
			<th class="text-center">Principle</th>
			<th class="text-center">#</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($row as $item)
		<tr>
			<td>{{ $item->kd }}</td>
			<td>{{ isset($item->employee) ? $item->employee->name : '' }}</td>
			<td>{{ isset($item->jabatan) ? $item->jabatan->title : ''  }}</td>
			<td>{{ isset($item->cabang) ?  $item->cabang->title : '' }}</td>
			<td>{{ isset($item->divisi) ?  $item->divisi->title : '' }}</td>
			<td class="text-center">
				<a href="javascript:void(0);" class="update" data-id="{{ $item->id }}">
					<span class="badge badge-info">Update</span>
				</a>
				@if (empty($item->users_id))
				<a href="javascript:void(0);" class="delete" data-id="{{  $item->id }}">
					<span class="badge badge-danger">Delete</span>
				</a>
				@endif
			</td>
		</tr>		
		@endforeach
	</tbody>
</table>
<script type="text/javascript">
  $(document).ready(function(){
    $(".update").click(function(e) {
      var id = $(this).data('id');
      var url = '{{ route('backend.employee.sloting.edit') }}';
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

		$(".delete").click(function(e) {
			var id = $(this).data('id');
      var url = '{{ route('backend.employee.sloting.delete') }}';
			var token = '{{ csrf_token() }}';
			swalInit.fire({
				title: 'Anda yakin hapus ?',
				icon: 'warning',
				showCancelButton: true,
				confirmButtonText: 'Yes, delete it!',
				cancelButtonText: 'No, cancel!',
				buttonsStyling: false,
				customClass: {
					confirmButton: 'btn btn-success',
					cancelButton: 'btn btn-danger'
				}
			}).then(function(result) {
				if(result.value) {
					$.ajax({
						url: url,
						type: "POST",
						data : { id:id, _token:token },
						dataType : "JSON",
						success: function (response){
							$("#modalEx").modal('hide');
							swalInit.fire(
								'Deleted!',
								'Your file has been deleted.',
								'success'
							);
							sloting_search(response.department, response.cabang);
						}
					});
				} else if(result.dismiss === swal.DismissReason.cancel) {
					swalInit.fire(
						'Cancelled',
						'Your imaginary file is safe :)',
						'error'
					);
				}
			});
		});
	});
</script>