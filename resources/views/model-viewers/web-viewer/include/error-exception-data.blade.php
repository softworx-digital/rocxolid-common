@can ('view', $component->getModel())
<div id="{{ $component->getDomId('error-exception-data') }}" class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">
            {{ $component->translate('text.error-exception-data') }}
        @can ('update', $component->getModel())
            <a data-ajax-url="{{ $component->getController()->getRoute('edit', $component->getModel(), ['_section' => 'error-exception-data']) }}" class="margin-left-5 pull-right" title="{{ $component->translate('button.edit') }}"><i class="fa fa-pencil"></i></a>
        @endcan
        </h3>
    </div>
    <div class="panel-body">
        <dl class="dl-horizontal">
        @foreach ($component->getModel()->getErrorExceptionDataAttributes() as $_attribute => $value)
            <dt>{{ $component->translate(sprintf('field.%s', $_attribute)) }}</dt>
            <dd>
            @if ($component->getModel()->isBooleanAttribute($_attribute))
                @if ($component->getModel()->$_attribute)
                    <i class="fa fa-check text-success"></i>
                @else
                    <i class="fa fa-close text-danger"></i>
                @endif
            @elseif ($component->getModel()->isJsonAttribute($_attribute))
                JSON - // @todo
            @elseif ($component->getModel()->isColorAttribute($_attribute))
                <span class="label" style="background-color: {{ $component->getModel()->$_attribute }};">{{ $component->getModel()->$_attribute }}</span>
            @else
                {!! $component->getModel()->getAttributeViewValue($_attribute) !!}
            @endif
            </dd>
        @endforeach
        </dl>
    </div>
</div>
@endcan