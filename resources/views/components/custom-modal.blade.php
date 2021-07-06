@props(['modalId' => '', 'headerVariant' => 'primary', 'tabIndex' => -1, 'classes' => ''])

<div class="modal fade mt-5 {{ $classes }}" id="{{ $modalId }}" tabindex="{{ $tabIndex }}" role="dialog"
    aria-labelledby="{{ $modalId }}Label" aria-hidden="true">
    <div class="modal-dialog pt-5" role="document">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="card card-{{ $headerVariant }} w-100 mb-0" style="margin-bottom: 0 !important">
                    <div class="card-header d-flex align-items-center justify-content-center">
                        <h3 class="card-title w-100 text-right">
                            {{ $title }}
                        </h3>
                        <span class="close text-white" data-dismiss="modal">&times;</span>
                    </div>
                    {{ $body }}
                </div>
            </div>
        </div>
    </div>
</div>
