<div class="modal-dialog modal-lg">
  <div class="modal-content">
		<div class="modal-header">
			<h6 class="modal-title" id="myLargeModalLabel">Detail Biaya</h6>
		</div>
    <div class="modal-body">
			<table class="table table-bordered table-sm">
				<tr>
					<td colspan="2">
						<strong>Estimasi Biaya Kendaraan</strong>
					</td>
					<td>@currency($get->estimasi_harga)</td>
				</tr>
				<tr>
					<td colspan="2">
						<strong>Uang Makan</strong>
					</td>
					<td>@currency($get->uang_makan)</td>
				</tr>
				<tr>
					<td colspan="2">
						<strong>Uang Hotel</strong>
					</td>
					<td>@currency($get->uang_hotel)</td>
				</tr>
				<tr>
					<td colspan="2">
						<strong>Estimasi Total Biaya</strong>
					</td>
					<td><strong>@currency($get->total_harga)</strong></td>
				</tr>
			</table>
			<div class="form-group row">
				<div class="col-md-6">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				</div>
			</div>
    </div>
  </div>
</div>