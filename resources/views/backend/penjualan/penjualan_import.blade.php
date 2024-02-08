@extends('crudbooster::admin_template')
@section('content')
<div class="box box-primary">
    <div class="box box-body">
        <p>
            <a href="{{action('AdminTSalesHeaderController@getIndex')}}" class="btn btn-xs btn-primary">&laquo; Kembali</a>
        </p>
        @if(session()->has('error'))   
        <div class="alert alert-warning alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-warning"></i> {{session()->get('error')}} !</h4>
            Import Data Gagal.<br> 
            {{session()->get('msg')}} 
        </div>
        @elseif(session()->has('data'))   
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i> Success!</h4>
            Import Data berhasil. <br>
            {{session()->get('total')}} Data berhasil terupload<br>
          </div>
        @endif
		<div class="panel panel-default">
            <div class="panel-heading">Import Data Box</div>
			<form method="post" enctype="multipart/form-data" action="">
				{!! csrf_field() !!}
			<div class="panel-body">
				
				{{-- <div class="form-group">
					<label>Tanggal</label>
					<input type="text" class="form-control datepicker" required name="date" id="date">
				</div> --}}
				<div class="form-group">
					<label>File XLS</label>
					<input type="file" class="form-control" required name="userfile">
					<div class="help-block">
						File format .xls, .xlsx. Unduh format template <a href="{{asset('format_import/format import box.xlsx')}}" target="_blank">Klik disini</a>
					</div>
				</div>

			</div>
			<div class="panel-footer">
				<input type="submit" class="btn btn-primary" value="Import">
			</div>
			</form>
        </div>		
    </div>
</div>
@endsection
@push("bottom")
<script>
    // $("#date").datepicker();
</script>
@endpush