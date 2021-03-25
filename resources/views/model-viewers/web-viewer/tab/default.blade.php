<div class="row">
    <div class="col-xl-8 col-md-6 col-xs-12">
        <div class="row">
            {!! $component->render('include.general-data') !!}
            {!! $component->render('include.description-data') !!}
        </div>
    </div>
    <div class="col-xl-4 col-md-6 col-xs-12">
        <div class="row">
            {!! $component->render('include.localization-data') !!}
            {!! $component->render('include.label-data') !!}
        </div>
    </div>
</div>



@if (false)
    <div class="col-xl-3 col-md-4 col-xs-12">
        <div class="row">
        @if ($component->getModel()->image()->exists())
            {!! $component->getModel()->image->getModelViewerComponent()->render('related.show', [ 'attribute' => 'image', 'relation' => 'parent' ]) !!}
        @else
            {!! $component->getModel()->image()->make()->getModelViewerComponent()->render('related.unavailable', [
                'attribute' => 'image',
                'relation' => 'parent',
                'related' => $component->getModel(),
            ]) !!}
        @endif
            {!! $component->render('include.activity-data') !!}
        </div>
    </div>
    <div class="col-xl-5 col-md-4 col-xs-12">
        <div class="row">
        @if ($component->getModel()->profile()->exists())
            {!! $component->getModel()->profile->getModelViewerComponent()->render('related.show', [ 'attribute' => 'profile', 'relation' => 'user' ]) !!}
        @else
            {!! $component->getModel()->profile()->make()->getModelViewerComponent()->render('related.unavailable', [ 'attribute' => 'profile', 'relation' => 'user', 'related' => $component->getModel() ]) !!}
        @endif
        @if ($component->getModel()->company()->exists())
            {!! $component->getModel()->company->getModelViewerComponent()->render('related.show', [ 'attribute' => 'company', 'relation' => 'user' ]) !!}
        @else
            {!! $component->getModel()->company()->make()->getModelViewerComponent()->render('related.unavailable', [ 'attribute' => 'company', 'relation' => 'user', 'related' => $component->getModel() ]) !!}
        @endif
        </div>
    </div>
    <div class="col-xl-4 col-md-4 col-xs-12">
        <div class="row">
        @if ($component->getModel()->address()->exists())
            {!! $component->getModel()->address->getModelViewerComponent()->render('related.show', [ 'attribute' => 'address', 'relation' => 'parent' ]) !!}
        @else
            {!! $component->getModel()->address()->make()->getModelViewerComponent()->render('related.unavailable', [ 'attribute' => 'address', 'relation' => 'parent', 'related' => $component->getModel() ]) !!}
        @endif
            {!! $component->render('include.authentication-data') !!}
            {!! $component->render('include.authorization-data') !!}
        </div>
    </div>
@endif