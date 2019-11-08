<div id="{{ $component->getDomId() }}">
    <h2>
        {{ $component->translate('model.title.singular') }}
    @if ($component->getModel()->userCan('write'))
        <a data-ajax-url="{{ $component->getModel()->getControllerRoute('edit') }}" class="margin-left-5"><i class="fa fa-pencil"></i></a>
    @endif
    </h2>
    <div>
        {!! $component->getModel()->getModelViewerComponent()->render('include.data') !!}
    </div>
</div>