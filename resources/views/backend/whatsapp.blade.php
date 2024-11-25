@extends('layouts.backend2.app')
@section('content')
<div class="page-content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="page-title-box d-flex align-items-center justify-content-between">
					<h4 class="mb-0"><?php echo $title;?></h4>
					<div class="page-title-right">
						<ol class="breadcrumb m-0">
							<li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
							<li class="breadcrumb-item active">Whatsapp Monitor</li>
						</ol>
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
									<th class="text-center">Subject</th>
									<th class="text-center">Nomor Hp</th>
									<th class="text-center">Message</th>
									<th class="text-center">Status</th>
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
									<td>{{ $item->subject }}</td>
									<td>{{ $item->no_wa }}</td>
									<td>{!! $item->message !!}</td>
									<td class="text-center">
										{!! $item->status !!}
									</td>
									<td class="text-center">
										<a href="{{ route('backend.whatsapp_resend',$item->id) }}" onclick="return confirm('Anda yakin ingin kirim ulang ?')" class="badge badge-primary">Send WA</a>
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
