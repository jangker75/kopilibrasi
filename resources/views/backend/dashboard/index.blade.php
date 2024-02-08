<!-- First you need to extend the CB layout -->
@extends('crudbooster::admin_template')
@section('content')
@push('head')
    <style>
.grid-container {
  display: grid;
  grid-template-columns: auto auto;
  grid-gap: 10px;
  padding: 10px;
}
    </style>
@endpush
<div class="row">
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-aqua"><i class="fa fa-money"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Total Pemasukan</span>
          <span class="info-box-number">Rp. {{ number_format($dataTotal["penjualan"]->total) }}</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-orange"><i class="fa fa-money"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Total Pengeluaran</span>
          <span class="info-box-number">Rp. {{ number_format($dataTotal["pengeluaran"]->total) }}</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    
</div>
<div class="box box-default">
  <div class="box-header with-border">
    <h3>Grafik Penjualan Harian</h3>
  </div>
  <div class="box-body">
    <div class="row">
      <div class="col-md-12">
        <div class="chart-container" style="height: 40vh;">
          <canvas id="bar_penjualan"></canvas>
        </div>
      </div>
    </div>
  </div>
  
</div>
@endsection

@push('bottom')
@include('backend.dashboard.script_index')
@endpush