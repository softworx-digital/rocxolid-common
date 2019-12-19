<div id="{{ $component->getDomId('modal-show', $component->getModel()->id) }}" class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ajax-overlay">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">{{ $component->translate('model.title.singular') }} <small>{{ $component->translate(sprintf('action.%s', $route_method)) }}</small></h4>
            </div>

            <div class="modal-body">
                {!! $component->render('include.data') !!}
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-chevron-left margin-right-10"></i>{{ $component->translate('button.close') }}</button>
            @if ($component->getModel()->userCan('write'))
                <a href="{{ $component->getModel()->getControllerRoute('edit') }}" class="btn btn-primary pull-right"><i class="fa fa-pencil margin-right-10"></i>{{ $component->translate('button.edit') }}</a>
            @endif
            </div>
        </div>
    </div>
</div>