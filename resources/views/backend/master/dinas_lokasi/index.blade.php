@extends('layouts.backend2.app')
@section('content')
<div class="page-content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="page-title-box d-flex align-items-center justify-content-between">
					<h4 class="mb-0"><?php echo $title;?></h4>
					{{-- <div class="page-title-right">
						<a href="#" class="btn btn-success btn-sm export">Export</a>
						<a href="{{ route('backend.employee.create') }}" class="btn btn-primary btn-sm">Tambah Data</a>
					</div> --}}
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xl-12">
				@include('backend.template.alert')
				<div class="card">
					<div class="card-body">
						<table class="table table-sm table-striped table-bordered datatable-basic">
							<thead>
								<tr>
									<th class="text-center" width="2px">No</th>
									<th class="text-center">Lokasi Asal</th>
									<th class="text-center">Lokasi Tujuan</th>
									<th class="text-center">Jarak</th>
									<th class="text-center" width="100px">#</th>
								</tr>
							</thead>
							<tbody>
								@php
										$no=1;
								@endphp
								@foreach ($row as $item)
								<tr>
									<td>{{ $no++ }}</td>
									<td>{{ isset($item->lokasi_asal) ? $item->lokasi_asal->title : '-' }}</td>
									<td>{{ isset($item->lokasi_tujuan) ? $item->lokasi_tujuan->title : '-' }}</td>
									<td>{{ $item->jarak }} Km</td>
									<td class="text-center">
										<a href="javascript:void(0);" class="edit" data-id="{{ $item->id }}">
											<span class="badge badge-success">Edit</span>
										</a>
										<a href="{{ route('backend.master.dinas_lokasi.delete',$item->id) }}" onclick="return confirm('Anda yakin ingin menghapus ?')">
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
		</div>
	</div>
</div>
<div id="modalEx" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
</div>
@endsection
@section('customjs')
<script type="text/javascript">
  $(document).ready(function(){
    $.extend( $.fn.dataTable.defaults, {
			iDisplayLength:25,        
      autoWidth: false,
			columnDefs: [{ 
				orderable: false,
				targets: [ 0 ]
			}],
      dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
      language: {
        search: '<span>Filter:</span> _INPUT_',
        searchPlaceholder: 'Type to filter...',
        lengthMenu: '<span>Show:</span> _MENU_',
        paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }
      }
    });

    var oTable = $('.datatable-basic').DataTable({
    	"select": "single",
    	"serverSide": false,
    	drawCallback: function() {
        $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');

				$(".edit").unbind();
				$(".edit").click(function(e) {
					var id = $(this).data('id');
					var url = '{{ route('backend.master.dinas_lokasi.edit') }}';
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
      },
      preDrawCallback: function() {
        $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
      } 
    });
  });
</script>
@endsection