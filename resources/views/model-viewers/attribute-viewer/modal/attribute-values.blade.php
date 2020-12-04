<div class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content ajax-overlay">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">{{ $component->getModel()->getTitle() }} <small>{{ $component->translate('text.values') }}</small></h4>
            </div>
            <div class="modal-body">
                {!! $component->render('include.attribute-values') !!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-chevron-left margin-right-10"></i>{{ $component->translate('button.close') }}</button>
            </div>
        </div>
    </div>
</div>