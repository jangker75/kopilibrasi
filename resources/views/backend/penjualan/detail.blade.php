@extends('crudbooster::admin_template')
@section('content')
@push('head')
  @include('includes.datatables-styles')
@endpush
<div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Filter</h3>
    </div>
</div>
@endsection