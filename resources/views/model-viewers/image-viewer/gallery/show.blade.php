@can ('view', [ $component->getModel()->$relation, $attribute ])
<div id="{{ $component->getDomId($attribute) }}" class="panel panel-default">
    {!! $component->render('gallery.panel-heading', [ 'relation' => $relation, 'attribute' => $attribute ]) !!}
    <div class="panel-body padding-0">
        {!! $component->render('gallery.images', [ 'relation' => $relation, 'attribute' => $attribute ]) !!}
    </div>
    {!! $component->render('gallery.panel-footer', [ 'relation' => $relation, 'attribute' => $attribute ]) !!}
</div>
@endcan