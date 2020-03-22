<div id="{{ $component->getDomId('modal-destroy-confirm') }}" class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content ajax-overlay">
        {{ Form::open([ 'id' => $component->getDomId('destroy-confirmation-form', $component->getModel()->getKey()), 'url' => $component->getController()->getRoute('destroy', $component->getModel()) ]) }}
            {{ Form::hidden('_method', 'DELETE') }}
        @if (request()->has('_data.relation'))
            {{ Form::hidden('_data[relation]', collect(request()->get('_data'))->get('relation')) }}
        @endif
        @if (request()->has('_data.model_attribute'))
            {{ Form::hidden('_data[model_attribute]', collect(request()->get('_data'))->get('model_attribute')) }}
        @endif
        @if (request()->has('_data.model_type'))
            {{ Form::hidden('_data[model_type]', collect(request()->get('_data'))->get('model_type')) }}
        @endif
        @if (request()->has('_data.model_id'))
            {{ Form::hidden('_data[model_id]', collect(request()->get('_data'))->get('model_id')) }}
        @endif
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">{{ $component->translate('model.title.singular') }} <small>{{ $component->translate(sprintf('action.%s', $route_method)) }}</small></h4>
            </div>

            <div class="modal-body">
                <p class="text-center">{{ $component->translate('text.destroy-confirmation') }} {{ Str::lower($component->translate('model.title.singular')) }}?</p>
                <div class="row">
                    <div class="col-md-4 col-md-offset-4 col-xs-12">{{ $component->render('default', [ 'image' => $component->getModel(), 'size' => 'small' ]) }}</div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-chevron-left margin-right-10"></i>{{ $component->translate('button.close') }}</button>
                <button type="button" class="btn btn-danger pull-right" data-ajax-submit-form="{{ $component->getDomIdHash('destroy-confirmation-form', $component->getModel()->getKey()) }}"><i class="fa fa-trash margin-right-10"></i>{{ $component->translate('button.delete') }}</button>
            @if (false && $use_ajax)
                <button type="submit" class="btn btn-danger pull-right"><i class="fa fa-trash margin-right-10"></i>{{ $component->translate('button.delete') }}</button>
            @endif
            </div>
        {{ Form::close() }}
        </div>
    </div>
</div>