<div class="modal-dialog modal-md">
  <div class="modal-content">
    <div class="modal-body">
      <fieldset>
        <legend class="text-uppercase font-size-sm font-weight-bold">Info Biaya Uang Makan & Hotel</legend>
        <table class="table table-bordered table-striped table-hovered table-sm">
          <thead>
            <tr>
              <th class="text-center" width="2px">No</th>
              <th class="text-center">Jabatan</th>
              <th class="text-center">Uang Makan</th>
              <th class="text-center">Uang Hotel</th>
            </tr>
          </thead>
          <tbody>
            @php
              $no = 1;
            @endphp
            @foreach ($row as $item)                
            <tr>
              <td class="text-center">{{ $no++ }}</td>
              <td>{{ $item->jabatan->title }}</td>
              <td class="text-right">{!! rupiah2($item->uang_makan) !!}</td>
              <td class="text-right">{!! rupiah2($item->uang_hotel) !!}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
        <button type="button" class="btn btn-danger btn-sm mt-2" data-dismiss="modal">Close</button>
      </fieldset>
    </div>
  </div>
</div>