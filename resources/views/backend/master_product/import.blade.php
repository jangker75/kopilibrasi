@extends('crudbooster::admin_template')
@section('content')
<div style="margin-bottom: 20px">
    <a class="btn btn-primary btn-sm" href="{{ CRUDBooster::mainpath() }}">Back to {{$page}}</a>
</div>
        @if(session()->has('error'))   
        <div class="alert alert-warning alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-warning"></i> {{session()->get('error')}} !</h4>
            Import Data Gagal.<br> 
            {{session()->get('total')}} Data berhasil terupload <br>
            {{session()->get('totalexist')}} Data Sudah Ada (tidak upload) <br>
            {{session()->get('msg')}} 
        </div>
        @elseif(session()->has('data'))   
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i> Success!</h4>
            Import Data berhasil. <br>
            {{session()->get('total')}} Data berhasil terupload<br>
            {{session()->get('totalexist')}} Data Sudah Ada (tidak upload) <br>
          </div>
        @endif


		<div class="panel panel-default">
			<div class="panel-heading">{{$page_title}}</div>
			<form method="post" enctype="multipart/form-data" action="">
				{!! csrf_field() !!}
			<div class="panel-body">
				<div class="form-group">
					<label>File XLS</label>
					<input type="file" accept=".xls, .xlsx" class="form-control" required name="userfile">
					<div class="help-block">
						File format .xls, .xlsx. Unduh format template <a href="{{asset('backend/import_template/import_master_product.xlsx')}}" target="_blank">Klik disini</a>
					</div>
				</div>
			</div>
			<div class="panel-footer">
				<input type="submit" class="btn btn-primary" value="Import">
			</div>
			</form>
		</div>
@endsection

@push('head')
    <style>

div.wrap {
    overflow:hidden;
    overflow-y: scroll;
    height: 400px;
}
    </style>
@endpush