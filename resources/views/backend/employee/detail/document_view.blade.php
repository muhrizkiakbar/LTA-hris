<div class="modal-dialog modal-lg">
  <div class="modal-content">
		<div class="modal-header">
			<h6 class="modal-title" id="myLargeModalLabel">{{ $title }}</h6>
		</div>
		<div class="modal-body">
			@if ($file_type=='pdf')
			<embed src="{{ Storage::url('upload/employee/'.$nik.'/'.$file) }}" frameborder="0" width="100%" height="500px">	
			@else
			<img src="{{ Storage::url('upload/employee/'.$nik.'/'.$file) }}" class="img-fluid">
			@endif
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-danger btn-sm mt-2" data-dismiss="modal">Close</button>
 		</div>
	</div>
</div>