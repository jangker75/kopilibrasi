<div class="row">
  <div class="col-12">
    <div class="card">
      @if(isset($card_header) && $card_header == 'true')
      <div class="card-header @isset($card_header_class) {{ $card_header_class }} @endisset">
        {{ $card_header_content }}
      </div>
      @endif
      {{-- <div class="card-body"> --}}

        @isset($buttons)
          <div style="margin-bottom: 10px" id="buttons" class="buttons @isset($buttons_class) {{ $buttons_class }} @endisset">
            {{ $buttons }}
          </div>
        @endisset
        
        <div class="table-responsive">
          <table class="table table-hover table-striped dataTable" data-scroll-y="350" id="{{ $table_id }}">
            <thead>
              {{ $table_header }}
            </thead>
            
          </table>
        </div>
      {{-- </div> --}}
    </div>
  </div>
</div>

@push('head')
  @include('includes.datatables-styles')
@endpush

@push('bottom')
  @include('includes.datatables-scripts')

  <script>
    $.extend(true, $.fn.dataTable.defaults, {
      columnDefs: {
        targets: '_all',
        defaultContent: '-'
      },
      stateSave: true,
      scrollX: true,
      scrollCollapse: true,
      language: {
        url: "{{asset('backend/datatables_bahasa.json')}}",
      },
    });
  </script>

@endpush