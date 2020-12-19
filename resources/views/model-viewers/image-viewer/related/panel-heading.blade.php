<div class="panel-heading">
    <div class="row">
    @if (!($read_only ?? false))
    @if (false)
        <div class="col-sm-5 col-xs-11">
            <h3 class="panel-title margin-top-7">
                {{ $component->translate('model.title.singular') }}{{-- @todo: parent field name here --}}
            </h3>
        </div>
        <div class="col-sm-7 col-xs-1">
    @endif
        <div class="col-xs-12">
            <div class="btn-group btn-group-sm center-block hidden-xs" role="group">
            @can ('create', [ $component->getModel()->$relation, $attribute ])
                <a
                    class="btn btn-default"
                    data-ajax-url="{{ $component->getModel()->getControllerRoute('create', $component->getModel()->getRouteRelationParam($attribute, $relation, $component->getModel()->$relation)) }}">
                    <i class="fa fa-upload margin-right-5"></i>{{ $component->translate('button.upload-image') }}
                </a>
            @endcan
            @can ('update', [ $component->getModel()->$relation, $attribute ])
                <a
                    class="btn btn-default"
                    data-ajax-url="{{ $component->getModel()->getControllerRoute('edit', $component->getModel()->getRouteRelationParam($attribute, $relation)) }}">
                    <i class="fa fa-pencil margin-right-5"></i>{{ $component->translate('button.edit') }}
                </a>
            @endcan
            @can ('delete', [ $component->getModel()->$relation, $attribute ])
                <a
                    class="btn btn-default"
                    data-ajax-url="{{ $component->getModel()->getControllerRoute('destroyConfirm', $component->getModel()->getRouteRelationParam($attribute, $relation)) }}">
                    <i class="fa fa-trash margin-right-5"></i>{{ $component->translate('button.delete') }}
                </a>
            @endcan
            </div>

            <div class="btn-group btn-group-sm pull-right visible-xs-block">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="caret"></span></button>
                <ul class="dropdown-menu">
                @can ('create', [ $component->getModel()->$relation, $attribute ])
                    <li><a data-ajax-url="{{ $component->getModel()->getControllerRoute('create', $component->getModel()->getRouteRelationParam($attribute, $relation, $component->getModel()->$relation)) }}">
                        <i class="fa fa-upload margin-right-5"></i>{{ $component->translate('button.upload-image') }}
                    </a></li>
                @endcan
                @can ('update', [ $component->getModel()->$relation, $attribute ])
                    <li><a data-ajax-url="{{ $component->getModel()->getControllerRoute('edit', $component->getModel()->getRouteRelationParam($attribute, $relation)) }}">
                        <i class="fa fa-pencil margin-right-5"></i>{{ $component->translate('button.edit') }}
                    </a></li>
                @endcan
                @can ('delete', [ $component->getModel()->$relation, $attribute ])
                    <li><a data-ajax-url="{{ $component->getModel()->getControllerRoute('destroyConfirm', $component->getModel()->getRouteRelationParam($attribute, $relation)) }}">
                        <i class="fa fa-trash margin-right-5"></i>{{ $component->translate('button.delete') }}
                    </a></li>
                @endcan
                </ul>
            </div>
        </div>
    @endif
    </div>
</div>