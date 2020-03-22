<div class="btn-group btn-group-sm center-block hidden-xs show-up" role="group">
    <a class="btn btn-default" href="{{ asset(sprintf('storage/%s', $image->getStorageRelativePath())) }}" data-toggle="lightbox" data-gallery="{{ $attribute }}"><i class="fa fa-arrows-alt"></i></a>
    <span class="btn btn-default drag-handle"><i class="fa fa-arrows"></i></span>
@can ('update', [ $image->$relation, $attribute ])
    <button class="btn btn-primary" data-ajax-url="{{ $image->getControllerRoute('edit', $image->getRouteRelationParam($attribute, $relation)) }}"><i class="fa fa-pencil"></i></button>
@endcan
@can ('delete', [ $image->$relation, $attribute ])
    <button class="btn btn-danger" data-ajax-url="{{ $image->getControllerRoute('destroyConfirm', $image->getRouteRelationParam($attribute, $relation)) }}"><i class="fa fa-trash"></i></button>
@endcan
</div>

<div class="btn-group btn-group-sm pull-right visible-xs-block">
    <a class="btn btn-default" href="{{ asset(sprintf('storage/%s', $image->getStorageRelativePath())) }}" data-toggle="lightbox" data-gallery="{{ $attribute }}"><i class="fa fa-arrows-alt"></i></a><span class="btn btn-default drag-handle"><i class="fa fa-arrows"></i></span>
    <span class="btn btn-default drag-handle"><i class="fa fa-arrows"></i></span>
    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="caret"></span></button>
    <ul class="dropdown-menu">
    @can ('update', [ $image->$relation, $attribute ])
        <li><a data-ajax-url="{{ $image->getControllerRoute('edit', $image->getRouteRelationParam($attribute, $relation)) }}">
            <i class="fa fa-pencil margin-right-5"></i>{{ $component->translate('button.edit') }}
        </a></li>
    @endcan
    @can ('delete', [ $image->$relation, $attribute ])
        <li><a data-ajax-url="{{ $image->getControllerRoute('destroyConfirm', $image->getRouteRelationParam($attribute, $relation)) }}">
            <i class="fa fa-trash margin-right-5"></i>{{ $component->translate('button.delete') }}
        </a></li>
    @endcan
    </ul>
</div>