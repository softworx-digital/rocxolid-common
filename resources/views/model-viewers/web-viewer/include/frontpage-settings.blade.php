<div id="{{ $component->getDomId('frontpage-settings') }}">
@if ($component->getModel()->frontpageSettings()->exists())
    {!! $component->getModel()->frontpageSettings->getModelViewerComponent()->render('related.show', [ 'attribute' => 'frontpageSettings', 'relation' => 'web' ]) !!}
@else
    {!! $component->getModel()->frontpageSettings()->make()->getModelViewerComponent()->render('related.unavailable', [
        'attribute' => 'frontpageSettings',
        'relation' => 'web',
        'related' => $component->getModel(),
    ]) !!}
@endif
</div>