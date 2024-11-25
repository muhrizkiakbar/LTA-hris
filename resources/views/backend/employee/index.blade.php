@extends('layouts.backend2.app')
@section('content')
<div class="page-content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="page-title-box d-flex align-items-center justify-content-between">
					<h4 class="mb-0"><?php echo $title;?></h4>
					<div class="page-title-right">
						<a href="#" class="btn btn-success btn-sm export">Export</a>
						<a href="{{ route('backend.employee.create') }}" class="btn btn-primary btn-sm">Tambah Data</a>
					</div>
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
									<th class="text-center">Lokasi</th>
									<th class="text-center">Divisi</th>
									<th class="text-center">Department</th>
									<th class="text-center">#</th>
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
									<td class="text-center">{{ isset($item->lokasi) ? $item->lokasi : '-' }}</td>
									<td class="text-center">{{ isset($item->divisi) ? $item->divisi->title : '-' }}</td>
									<td class="text-center">{{ isset($item->department) ? $item->department->title : '-' }}</td>
									<td class="text-center">
										<a href="{{ route('backend.employee.detail',$item->id) }}" target="_blank">
											<span class="badge badge-success">Detail</span>
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
      },
      preDrawCallback: function() {
        $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
      } 
    });

		$(".export").click(function(e) {
      var url = '{{ route('backend.employee.export') }}';
			var token = '{{ csrf_token() }}';
      $.ajax({
        url: url,
        type: "POST",
        data : { _token:token },
        success: function (ajaxData){
          $("#modalEx").html(ajaxData);
          $("#modalEx").modal('show',{backdrop: 'true'});
        }
      });
    });
  });
</script>
@endsection