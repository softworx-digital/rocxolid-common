<div id="{{ $component->getDomId($attribute, 'images') }}" class="row">
    <ul class="list-unstyled {{-- grid --}} sortable images col-xs-12 margin-0"
        data-update-url="{{ $component->getModel()->$relation->getControllerRoute('reorder', [ 'relation' => $attribute ]) }}"
        {{-- data-masonry='{ "itemSelector": "li", "columnWidth": 256 }' --}}>
    @foreach ($component->getModel()->$relation->$attribute as $image)
        <li data-item-id="{{ $image->getKey() }}" class="d-inline-block col-md-2 col-sm-3 col-xs-4 padding-0 grid-item ajax-overlay @if ($image->is_model_primary) highlight @endif" @if ($image->is_model_primary) title="{{ $component->translate('text.image-primary') }}" @endif>
            <div class="img img-small">
                {{ Html::image($image->getControllerRoute('get', [ 'size' => 'small-square' ]), $image->alt) }}
                <div class="btn-group btn-group-sm show-up">
                    <a class="btn btn-default" href="{{ asset(sprintf('storage/%s', $image->getStorageRelativePath())) }}" data-toggle="lightbox" data-gallery="{{ $attribute }}"><i class="fa fa-arrows-alt"></i></a>
                    <span class="btn btn-default drag-handle"><i class="fa fa-arrows"></i></span>
                    <button class="btn btn-primary" data-ajax-url="{{ $image->getControllerRoute('edit', [ '_section' => 'model' ]) }}"><i class="fa fa-pencil"></i></button>
                    <button class="btn btn-danger" data-ajax-url="{{ $image->getControllerRoute('destroyConfirm') }}"><i class="fa fa-trash"></i></button>
                </div>
            </div>
        </li>
    @endforeach
    </ul>
</div>