<div id="{{ $component->getDomId(md5(get_class($component->getModel()->$relation)), $component->getModel()->$relation->getKey(), $attribute, 'content') }}" class="row">
    <ul class="list-unstyled {{-- grid --}} sortable images col-xs-12 margin-0"
        data-update-url="{{ $component->getModel()->$relation->getControllerRoute('reorder', [ 'relation' => $attribute ]) }}"
        {{-- data-masonry='{ "itemSelector": "li", "columnWidth": 256 }' --}}>
    @foreach ($component->getModel()->$relation->$attribute as $image)
        <li data-item-id="{{ $image->getKey() }}" class="d-inline-block col-md-2 col-sm-3 col-xs-6 padding-0 grid-item ajax-overlay @if ($image->is_model_primary) highlight @endif" @if ($image->is_model_primary) title="{{ $component->translate('text.image-primary') }}" @endif>
        @if (false)
            <div class="img img-small has-controls">
                {{ Html::image($image->getControllerRoute('get', [ 'size' => 'small-square' ]), $image->alt) }}
                {!! $component->render('include.controls', [ 'attribute' => $attribute, 'relation' => $relation, 'image' => $image ]) !!}
            </div>
        @endif
            <div class="img img-small has-controls">
                {!! $component->render('default', [ 'image' => $image, 'size' => 'small-square', 'attribute' => $attribute, 'relation' => $relation ]) !!}
                {!! $component->render('include.controls', [ 'attribute' => $attribute, 'relation' => $relation, 'image' => $image ]) !!}
            </div>
        </li>
    @endforeach
    </ul>
</div>