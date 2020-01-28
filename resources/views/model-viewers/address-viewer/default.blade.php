<div id="{{ $component->getDomId() }}">
    <h2>
        {{ $component->translate('model.title.singular') }}
    todo data.blade
        <a data-ajax-url="{{ $component->getModel()->getControllerRoute('edit') }}" class="margin-left-5"><i class="fa fa-pencil"></i></a>

    </h2>
    <div>
        {!! $component->getModel()->getModelViewerComponent()->render('include.data') !!}
    </div>
</div>