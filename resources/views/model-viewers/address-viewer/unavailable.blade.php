<div id="{{ $component->getDomId() }}">
    <h2>
        {{ $component->translate('model.title.singular') }}
    @if ($component->getModel()->userCan('write'))
        <a data-ajax-url="{{ $component->getModel()->getControllerRoute('create', [ '_data[model_type]' => $model->getModelName(), '_data[model_id]' => $model->id ]) }}" class="margin-left-5"><i class="fa fa-pencil"></i></a>
    @endif
    </h2>
    <div class="text-center">
        <i class="fa fa-info-circle text-warning fa-2x text-vertical-align-middle margin-right-5"></i>
        {{ $component->translate('text.unavailable') }}
    </div>
</div>