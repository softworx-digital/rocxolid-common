<div id="{{ $component->getDomId('frontpage-settings') }}">
@if ($component->getModel()->frontpageSettings()->exists())
    {!! $component->getModel()->frontpageSettings->getModelViewerComponent()->render('related.show', [ 'attribute' => 'frontpageSettings', 'relation' => 'web' ]) !!}

    <div class="row">
        <div class="col-md-3 col-xs-12">
        @if ($component->getModel()->frontpageSettings->logo()->exists())
            {!! $component->getModel()->frontpageSettings->logo->getModelViewerComponent()->render('related.show', [
                'attribute' => 'logo',
                'relation' => 'parent',
            ]) !!}
        @else
            {!! $component->getModel()->frontpageSettings->logo()->make()->getModelViewerComponent()->render('related.unavailable', [
                'attribute' => 'logo',
                'relation' => 'parent',
                'related' => $component->getModel()->frontpageSettings,
            ]) !!}
        @endif
        </div>
        <div class="col-md-3 col-xs-12">
        @if ($component->getModel()->frontpageSettings->favicon()->exists())
            {!! $component->getModel()->frontpageSettings->favicon->getModelViewerComponent()->render('related.show', [
                'attribute' => 'favicon',
                'relation' => 'parent',
            ]) !!}
        @else
            {!! $component->getModel()->frontpageSettings->favicon()->make()->getModelViewerComponent()->render('related.unavailable', [
                'attribute' => 'favicon',
                'relation' => 'parent',
                'related' => $component->getModel()->frontpageSettings,
            ]) !!}
        @endif
        </div>
    </div>
@else
    {!! $component->getModel()->frontpageSettings()->make()->getModelViewerComponent()->render('related.unavailable', [
        'attribute' => 'frontpageSettings',
        'relation' => 'web',
        'related' => $component->getModel(),
    ]) !!}
@endif
</div>