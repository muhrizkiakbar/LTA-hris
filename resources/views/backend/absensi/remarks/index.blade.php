@extends('layouts.backend2.app')
@section('content')
<div class="page-content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="page-title-box d-flex align-items-center justify-content-between">
					<h4 class="mb-0"><?php echo $title;?></h4>
					<div class="page-title-right">
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xl-7">
				@include('backend.template.alert')
				<div class="card">
					<div class="card-body">
						<table class="table table-sm table-striped table-bordered datatable-basic">
							<thead>
								<tr>
									<th class="text-center" width="5px">No</th>
									<th class="text-center">Nama</th>
									<th class="text-center">Tanggal</th>
									<th class="text-center">Keterangan</th>
									<th class="text-center" width="120px">#</th>
								</tr>
							</thead>
							<tbody>
								@php
										$no=1;
								@endphp
								@foreach ($row as $item)
								<tr>
									<td>{{ $no++ }}</td>
									<td>{{ isset($item->employee) ? $item->employee->name : '-' }}</td>
									<td>{{ $item->date }}</td>
									<td>{{ $item->remarks }}</td>
									<td class="text-center">
										<a href="{{ route('backend.absensi.remarks_delete',$item->id) }}" onclick="return confirm('Anda yakin ingin menghapus ?')">
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
			<div class="col-xl-5">
				<div class="card">
					<div class="card-header bg-white">
						<h6>Tambah Data - {{ $title }}</h6>
					</div>
					<div class="card-body">
						{!! Form::open(['route'=>'backend.absensi.remarks_store','method'=>'POST','files' => true]) !!}
						@include('backend.absensi.remarks.form')
						<div class="form-group row">
							<div class="col-md-4"></div>
							<div class="col-md-6">
								<button class="btn btn-primary btn-sm" type="submit">Simpan</button>
							</div>
						</div>
						{!! Form::close() !!}
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

		$(".select2").select2({
			width: "100%"
		});

		$('.datepick').datepicker({
    	autoClose:true
    });

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