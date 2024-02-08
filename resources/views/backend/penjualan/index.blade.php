@extends('crudbooster::admin_template')
@section('content')
@push('head')
  @include('includes.datatables-styles')
@endpush
<div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Filter</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="box-header">
            <div class="box-body">
                <div class="row">
                    <div class="col-12">
                      <div class="card">
                        <table>
                            <table class="table table-hover table-striped dataTable" data-scroll-y="350" id="tableIndex">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Total Harga</th>
                                    <th>Total Diskon</th>
                                    <th>Total Item</th>
                                    <th>Total Penjualan</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{ $item->date }}</td>
                                        <td>{{ $item->total_price }}</td>
                                        <td>{{ $item->total_discount }}</td>
                                        <td>{{ $item->total_item }}</td>
                                        <td>{{ $item->total_sale }}</td>
                                        <td>
                                            <a href="{{ CRUDBOOSTER::mainpath('detail/'.$item->date) }}" class="btn btn-primary" title="Detail Data"><i class="fa fa-eye"></i></a>
                                            {{-- <a class="btn btn-primary">View Detail</a> --}}
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
</div>

@push('bottom')
  @include('includes.datatables-scripts')
  @include('backend.penjualan.index-script')
@endpush
@endsection