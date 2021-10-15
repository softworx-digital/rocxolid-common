<div id="{{ $component->getDomId('attributes') }}" class="row">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-sm-8 col-xs-11">
                    <h3 class="panel-title margin-top-7">{{ $component->translate('text.attributes-data') }}</h3>
                </div>
                <div class="col-sm-4 col-xs-1">
                    {!! $component->getModel()->attributes()->make()->getModelViewerComponent()->render('related.snippet.create-button', [
                        'attribute' => 'attributes',
                        'relation' => 'attributeGroup',
                        'related' => $component->getModel(),
                        'size' => 'sm',
                    ]) !!}
                </div>
            </div>
        </div>
        <div class="panel-body padding-0">
            {!! $component->getModel()->getAttributesTableComponent()->render('include.results', [
                'no_margin' => true,
            ]) !!}
        </div>
    </div>
</div>