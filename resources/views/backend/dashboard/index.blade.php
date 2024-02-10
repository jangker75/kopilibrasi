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
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-green"><i class="fa fa-money"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Kas Rekening</span>
          <span class="info-box-number">Rp. {{ number_format($dataTotal["kas"]) }}</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    
</div>
<div class="box box-default">
  <div class="box-body">
    <div class="row">
      <div class="col-md-6">
        <div class="box-header with-border">
          <h3>Grafik Penjualan Harian</h3>
        </div>
        <div class="chart-container" style="height: 40vh;">
          <canvas id="bar_penjualan"></canvas>
        </div>
      </div>
      <div class="col-md-6">
        <div class="box-header with-border">
          <h3>Top Item Selling last 30 Days</h3>
        </div>
        <table class="table table-borderless">
          <thead>
            <tr>
              <th>No</th>
              <th>Item</th>
              <th>QTY</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody>
            @if (isset($dataTopItem) || count($dataTopItem) < 1)
                <tr>
                  <td align="center" colspan="4">No data to show</td>
                <tr>
            @endif
            @foreach ($dataTopItem as $item)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $item->item }}</td>
                  <td>{{ number_format($item->qty) }}</td>
                  <td>Rp. {{ number_format($item->total) }}</td>
                </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<div class="box box-default">
  <div class="box-body">
    <div class="row">
      <div class="col-md-12">
        <div class="box-header with-border">
          <h3>Grafik Penjualan dan Pengeluaran Bulanan</h3>
        </div>
        <div class="chart-container" style="height: 40vh;">
          <canvas id="bar_penjualan_monthly"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('bottom')
@include('backend.dashboard.script_index')
@endpush