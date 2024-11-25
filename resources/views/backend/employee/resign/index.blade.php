@extends('layouts.backend2.app')
@section('content')
<div class="page-content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="page-title-box d-flex align-items-center justify-content-between">
					<h4 class="mb-0"><?php echo $title;?></h4>
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
									<th class="text-center">NIK</th>
									<th class="text-center">Nama</th>
									<th class="text-center" width="150px">Tanggal Resign</th>
									<th class="text-center" width="150px">Alasan Resign</th>
									<th class="text-center" width="100px">Status</th>
									<th class="text-center">Keterangan</th>
									<th class="text-center" width="80px">#</th>
								</tr>
							</thead>
							<tbody>
								@php
										$no=1;
								@endphp
								@foreach ($row as $item)
								<tr>
									<td>{{ $no++ }}</td>
									<td>{{ $item->nik }}</td>
									<td>{{ $item->name }}</td>
									<td class="text-center">{{ $item->resign_date }}</td>
									<td class="text-center">{{ $item->resign_type }}</td>
									<td class="text-center">{!! $item->resign_status !!}</td>
									<td>{{ $item->resign_reason }}</td>
									<td class="text-center">
										<a href="{{ route('backend.employee.detail',$item->id) }}" target="_blank">
											<span class="badge badge-info">Detail</span>
										</a>
										@if ($role==1 || $role==3)
										<a href="{{ route('backend.employee.reactive',$item->id) }}" onclick="return confirm('Anda yakin ingin mengaktifkan karyawan ?')">
											<span class="badge badge-warning">Reactive</span>
										</a>	
										@endif
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

      },
      preDrawCallback: function() {
        $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
      } 
    });
  });
</script>
@endsection