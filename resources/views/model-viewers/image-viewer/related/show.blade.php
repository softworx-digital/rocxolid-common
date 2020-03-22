@can ('view', [ $component->getModel()->$relation, $attribute ])
<div id="{{ $component->getDomId($attribute) }}" class="panel panel-default overflow-hidden">
    {!! $component->render('related.panel-heading', [ 'relation' => $relation, 'attribute' => $attribute ]) !!}
    <div class="panel-body text-center text-primary padding-0">
        {!! $component->render('default', [ 'image' => $component->getModel(), 'size' => $size ?? 'mid' ]) !!}
    </div>
</div>
@endcan