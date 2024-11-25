@extends('layouts.backend2.app')
@section('content')
<div class="page-content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="page-title-box d-flex align-items-center justify-content-between">
					<h4 class="mb-0"><?php echo $title;?></h4>
					<div class="page-title-right">
						<a href="#" class="btn btn-primary btn-sm create">Tambah Data</a>
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
									<th class="text-center" width="1px">No</th>
                  <th class="text-center">Nama</th>
                  <th class="text-center">Email</th>
                  <th class="text-center">Role</th>
                  <th class="text-center">Lokasi</th>
                  <th class="text-center" width="70px">#</th>
								</tr>
							</thead>
							<tbody>
								@php
                  $no=1;
                @endphp
								@foreach ($row as $item)
								<tr>
									<td class="text-center">{{ $no++ }}</td>
                  <td>{{ $item->name }}</td>
                  <td>{{ $item->email }}</td>
                  <td class="text-center">{{ $item->role->title }}</td>
                  <td>{{ $item->user_lokasi }}</td>
									<td class="text-center">
										<div class="dropdown">
											<button class="btn btn-light btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
													Actions <i class="mdi mdi-chevron-down"></i>
											</button>
											<div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="">
												<a href="javascript:void(0);" data-id="{{ $item->id }}" class="dropdown-item edit">Edit</a>
												<a href="javascript:void(0);" data-id="{{ $item->id }}" class="dropdown-item edit_lokasi">Edit Lokasi</a>
												<a href="javascript:void(0);" data-id="{{ $item->id }}" class="dropdown-item editpass">Update Password</a>
												<a href="{{ route('backend.users.delete',$item->id) }}" onclick="return confirm('Anda yakin ingin menghapus ?')" class="dropdown-item">Delete</a>
											</div>
										</div>
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

		$('.datepick').datepicker({
    	autoClose:true
    });

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

				$(".edit").unbind();
				$(".edit").click(function(e) {
					var id = $(this).data('id');
					var url = '{{ route('backend.users.edit') }}';
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

				$(".edit_lokasi").unbind();
				$(".edit_lokasi").click(function(e) {
					var id = $(this).data('id');
					var url = '{{ route('backend.users.lokasi') }}';
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

				$(".editpass").unbind();
				$(".editpass").click(function(e) {
					var id = $(this).data('id');
					var url = '{{ route('backend.users.password') }}';
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

		$(".create").click(function(e) {
      var url = '{{ route('backend.users.create') }}';
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