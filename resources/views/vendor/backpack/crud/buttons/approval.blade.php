@if ($crud->hasAccess('approval'))
    @if($entry->approval != App\Enums\ApprovalType::APPROVED) 
        <a 
            href="javascript:void(0)" 
            onclick="approvalEntry(this)"
            data-route="{{ url($crud->route.'/'.$entry->getKey().'/approval') }}" 
            data-value="{{ App\Enums\ApprovalType::APPROVED }}" 
            data-message="承認されました。" 
            data-button-type="approval" 
            class="btn btn-sm btn-link"
        ><i class="la la-check"></i>承認</a>
    @endif
    @if($entry->approval != App\Enums\ApprovalType::DENIED) 
        <a 
            href="javascript:void(0)" 
            onclick="approvalEntry(this)"
            data-route="{{ url($crud->route.'/'.$entry->getKey().'/approval') }}" 
            data-value="{{ App\Enums\ApprovalType::DENIED }}" 
            data-message="否認されました。" 
            data-button-type="approval" 
            class="btn btn-sm btn-link"
        ><i class="la la-close"></i>否認</a>
    @endif
@endif

@push('after_scripts') @if (request()->ajax()) @endpush @endif
<script>
    if (typeof approvalEntry != 'function') {
      $("[data-button-type=approval]").unbind('click');

      function approvalEntry(button) {
          // ask for confirmation before deleting an item
          // e.preventDefault();
          var button = $(button);
          var route = button.attr('data-route');
          var value = button.attr('data-value');
          var message = button.attr('data-message');

          $.ajax({
              url: route,
              type: 'POST',
              data: { value: value },
              success: function(result) {
                new Noty({
                    type: "success",
                    text: message
                }).show();

                // Hide the modal, if any
                $('.modal').modal('hide');

                if (typeof crud !== 'undefined') {
                    crud.table.ajax.reload();
                }
              },
              error: function(result) {
                  // Show an alert with the result
                  new Noty({
                    type: "warning",
                    text: "造作が失敗しました。"
                  }).show();
              }
          });
      }
    }
</script>
@if (!request()->ajax()) @endpush @endif