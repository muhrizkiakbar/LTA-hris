@extends('layouts.backend2.app')
@section('content')
<div class="page-content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="page-title-box d-flex align-items-center justify-content-between">
					<h4 class="mb-0"><?php echo $title;?></h4>
					<div class="page-title-right">
						{{-- <a href="#" class="btn btn-primary btn-sm create">Generate</a> --}}
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
									<th class="text-center" width="2px">No</th>
									<th class="text-center">Periode</th>
									<th class="text-center" width="90px">#</th>
								</tr>
							</thead>
							<tbody>
								@php
									$no=1;
								@endphp
								@foreach ($row as $item)
								<tr>
									<td class="text-center">{{ $no++ }}</td>
									<td>{{ $item->periode }}</td>
									<td class="text-center">
										<a href="{{ route('backend.payroll.incentive.delete',$item->id) }}" onclick="return confirm('Anda yakin ingin menghapus ?')">
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
						<h6>{{ $title }}</h6>
					</div>
					<div class="card-body">
						{!! Form::open(['route'=>'backend.payroll.incentive.store','method'=>'POST','files' => true]) !!}
						@include('backend.payroll.incentive.form')
						
						<div class="form-group row">
							<div class="col-md-3"></div>
							<div class="col-md-6">
								<a href="https://hris.laut-timur.tech/storage/upload/csv/format_incentive.xlsx" target="_blank">
									Download template
								</a>
								<br>
								<button class="btn btn-success btn-sm" type="submit">Upload</button>
							</div>
						</div>
						{!! Form::close() !!}
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
		$('.datepick').datepicker();

    $.extend( $.fn.dataTable.defaults, {
			iDisplayLength:10,        
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