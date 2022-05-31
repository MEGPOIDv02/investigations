@php
    $modalSize = isset($modalSize)? $modalSize :'';
    $modalId = isset($modalId)? $modalId :'modal';
@endphp

<div id='{{$modalId}}' class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog {{$modalSize}} {{ isset($modalTop) ? '' : 'modal-dialog-centered' }}">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row text-right">
                    <div class="col-12">
                        @if(!isset($modalTitle))
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        @endif
                    </div>
                </div>
                <div class="body-content"></div>
            </div>
        </div>
    </div>
</div>
