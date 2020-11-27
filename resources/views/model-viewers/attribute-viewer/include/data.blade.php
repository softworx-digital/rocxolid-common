@foreach ($component->getModel()->getShowAttributes($except ?? []) as $field => $value)
    <div class="row">
        <label class="col-md-4 col-xs-6 text-right">{{ $component->translate(sprintf('field.%s', $field)) }}</label>
        <div class="col-md-8 col-xs-6 text-left">{{ $component->getModel()->$field }}</div>
    </div>
@endforeach
@foreach ($component->getModel()->getRelationshipMethods() as $method)
    <div class="row">
        <label class="col-md-4 col-xs-6 text-right">{{ $component->translate(sprintf('field.%s', $method)) }}</label>
        <div class="col-md-8 col-xs-6 text-left">
        @foreach ($component->getModel()->$method()->get() as $item)
            @if ($item->userCan('read-only'))
                <a class="label label-info" data-ajax-url="{{ $item->getControllerRoute() }}">{{ $item->getTitle() }}</a>
            @else
                <span class="label label-info">{{ $item->getTitle() }}</span>
            @endif
        @endforeach
        </div>
    </div>
@endforeach