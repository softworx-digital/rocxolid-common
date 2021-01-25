@if ($user->can('view', $component->getModel()))
<div id="{{ $component->getDomId('localization-data') }}" class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">
            {{ $component->translate('text.localization-data') }}
        @can ('update', $component->getModel())
            <a data-ajax-url="{{ $component->getController()->getRoute('edit', $component->getModel(), ['_section' => 'localization-data']) }}" class="margin-left-5 pull-right" title="{{ $component->translate('button.edit') }}"><i class="fa fa-pencil"></i></a>
        @endcan
        </h3>
    </div>
    <div class="panel-body">
        <dl class="dl-horizontal">
        @foreach ($component->getModel()->getLocalizationDataAttributes(true) as $attribute)
            @can ('assign', [ $component->getModel(), $attribute ])
                <dt>{{ $component->translate(sprintf('field.%s', $attribute)) }}</dt>
                <dd>
                @foreach ($component->getModel()->$attribute()->get() as $item)
                    @can ('update', $item)
                        <a class="label label-info" data-ajax-url="{{ $item->getControllerRoute() }}">{{ $item->getTitle() }}</a>
                    @elsecan('view', $item)
                        <span class="label label-info">{{ $item->getTitle() }}</span>
                    @endcan
                @endforeach
                </dd>
            @endcan
        @endforeach
        </dl>
    </div>
</div>
@endif