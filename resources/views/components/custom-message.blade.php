@props(['msg', 'variant' => 'danger'])

@if ($msg)
    <div class="alert alert-{{ $variant }} text-sm position-absolute alert-dismissible fade show" role="alert"
        style="left:16px">
        {{ $msg }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true" class="text-white">&times;</span>
        </button>
    </div>
@endif
