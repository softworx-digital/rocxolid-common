<div id="{{ $component->getDomId('modal-destroy-confirm', $component->getModel()->id) }}" class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content ajax-overlay">
        {{ Form::open([ 'url' => $component->getController()->getRoute('destroy', $component->getModel()) ]) }}
            {{ Form::hidden('_method', 'DELETE') }}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">{{ $component->translate('model.title.singular') }} <small>{{ $component->translate(sprintf('action.%s', $route_method)) }}</small></h4>
            </div>

            <div class="modal-body">
                <p class="text-center">{{ $component->translate('text.destroy-confirmation') }} {{ $component->getModel()->getTitle() }}?</p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-chevron-left margin-right-10"></i>{{ $component->translate('button.close') }}</button>
                <button type="submit" class="btn btn-danger pull-right"><i class="fa fa-trash-o margin-right-10"></i>{{ $component->translate('button.delete') }}</button>
            </div>
        {{ Form::close() }}
        </div>
    </div>
</div>