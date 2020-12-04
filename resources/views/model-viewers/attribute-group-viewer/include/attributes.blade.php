<div id="{{ $component->getDomId('attributes') }}" class="row">
    {!! $component->getModel()->attributes()->make()->getModelViewerComponent()->render('related.add', [
        'attribute' => 'attributes',
        'relation' => 'attributeGroup',
        'related' => $component->getModel(),
    ]) !!}
    {!! $component->getModel()->getAttributesTableComponent()->render('include.results') !!}
</div>