<div id="{{ $component->getDomId('attribute-values') }}" class="row">
    {!! $component->getModel()->attributeValues()->make()->getModelViewerComponent()->render('related.add', [
        'attribute' => 'attributeValues',
        'relation' => 'attribute',
        'related' => $component->getModel(),
    ]) !!}
    {!! $component->getModel()->getAttributeValuesTableComponent()->render('include.results') !!}
</div>