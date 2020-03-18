@can('view', [ $related, $attribute ])
<div id="{{ $component->getDomId($attribute) }}" class="panel panel-default overflow-hidden">
    <div class="panel-heading">
        <h3 class="panel-title">
            {{ $component->translate('model.title.singular') }}
        @can('create', [ $related, $attribute ])
            <a data-ajax-url="{{ $component->getModel()->getControllerRoute('create', $component->getModel()->getRouteRelationParam($attribute, $relation, $related)) }}" class="margin-left-5 pull-right" title="{{ $component->translate('button.upload-image') }}"><i class="fa fa-upload"></i></a>
        @endcan
        </h3>
    </div>
    <div class="panel-body text-center text-primary">
        {{ Html::image(sprintf('vendor/softworx/rocXolid/images/%s.svg', $placeholder ?? 'placeholder'), $attribute, [ 'style' => 'max-width: 100%; padding: 3em;' ]) }}
    </div>
</div>
@endcan