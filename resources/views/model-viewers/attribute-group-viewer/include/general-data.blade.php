@can ('view', $component->getModel())
<div id="{{ $component->getDomId('general-data') }}" class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">
            {{ $component->translate('text.general-data') }}
        @can ('update', $component->getModel())
            <a data-ajax-url="{{ $component->getController()->getRoute('edit', $component->getModel(), ['_section' => 'general-data']) }}" class="margin-left-5 pull-right" title="{{ $component->translate('button.edit') }}"><i class="fa fa-pencil"></i></a>
        @endcan
        </h3>
    </div>
    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>{{ $component->translate('field.title') }}</dt>
            <dd>{{ $component->getModel()->getTitle() }}</dd>
            <dt>{{ $component->translate('field.is_filterable') }}</dt>
            <dd>
            @if ($component->getModel()->is_filterable)
                <i class="fa fa-check text-success"></i>
            @else
                <i class="fa fa-close text-danger"></i>
            @endif
            </dd>
            <dt>{{ $component->translate('field.model_type') }}</dt>
            <dd>{{ $component->getModel()->getModelTypeTitle() }}</dd>
            <dt>{{ $component->translate('field.code') }}</dt>
            <dd>{{ $component->getModel()->getAttributeViewValue('code') }}</dd>
        </dl>
    </div>
</div>
@endcan