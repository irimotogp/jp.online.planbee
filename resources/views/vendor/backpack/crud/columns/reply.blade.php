@if ($entry->reply)
  <p>{{ $entry->reply }}</p>
@endif
@if (backpack_user()->hasRole('super'))
    @if ($entry->reply)
    <a href="{{ backpack_url("/review_reply/" . $entry->getKey() . "/edit") }}" class="btn btn-sm btn-link"><i class="la la-edit"></i>編集</a>
        <a 
            href="javascript:void(0)"
            onclick="removeReply(this)"
            data-route="{{ backpack_url("/review/" . $entry->getKey() . "/remove_reply") }}" 
            class="btn btn-sm btn-link"
            data-button-type="removeReply"
        ><i class="la la-edit"></i>削除</a>
    @else
    <a href="{{ backpack_url("/review_reply/" . $entry->getKey() . "/edit") }}" class="btn btn-sm btn-link"><i class="la la-reply"></i>回答</a>
    @endif

    @push('after_scripts') @if (request()->ajax()) @endpush @endif
    <script>
        if (typeof removeReply != 'function') {
        $("[data-button-type=removeReply]").unbind('click');

        function removeReply(button) {
            var button = $(button);
            var id = button.attr('data-id');
            var route = button.attr('data-route');

            $.ajax({
                url: route,
                type: 'POST',
                success: function(result) {
                    new Noty({
                        type: "success",
                        text: "削除されました。"
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
@endif