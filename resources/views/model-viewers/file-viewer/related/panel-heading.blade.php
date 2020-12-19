<div class="panel-heading">
    <div class="row">
    @if (!($read_only ?? false))
        <div class="col-sm-6 col-xs-10">
            <h4 class="text-overflow margin-top-7 margin-bottom-7">{{ $component->getModel()->parent->getModelViewerComponent()->translate(sprintf('field.%s', $component->getModel()->model_attribute)) }}</h4>
        </div>
        <div class="col-sm-6 col-xs-2">
            <div class="btn-group btn-group-sm pull-right hidden-xs" role="group">
            @can ('create', [ $component->getModel()->$relation, $attribute ])
                <a
                    class="btn btn-default"
                    data-ajax-url="{{ $component->getModel()->getControllerRoute('create', $component->getModel()->getRouteRelationParam($attribute, $relation, $component->getModel()->$relation)) }}">
                    <i class="fa fa-upload margin-right-5"></i>{{ $upload_button_label ?? $component->translate('button.upload') }}
                </a>
            @endcan
        @if (false)
            @can ('update', [ $component->getModel()->$relation, $attribute ])
                <a
                    class="btn btn-default"
                    data-ajax-url="{{ $component->getModel()->getControllerRoute('edit', $component->getModel()->getRouteRelationParam($attribute, $relation)) }}">
                    <i class="fa fa-pencil margin-right-5"></i>{{ $component->translate('button.edit') }}
                </a>
            @endcan
        @endif
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
                        <i class="fa fa-upload margin-right-5"></i>{{ $upload_button_label ?? $component->translate('button.upload') }}
                    </a></li>
                @endcan
            @if (false)
                @can ('update', [ $component->getModel()->$relation, $attribute ])
                    <li><a data-ajax-url="{{ $component->getModel()->getControllerRoute('edit', $component->getModel()->getRouteRelationParam($attribute, $relation)) }}">
                        <i class="fa fa-pencil margin-right-5"></i>{{ $component->translate('button.edit') }}
                    </a></li>
                @endcan
            @endif
                @can ('delete', [ $component->getModel()->$relation, $attribute ])
                    <li><a data-ajax-url="{{ $component->getModel()->getControllerRoute('destroyConfirm', $component->getModel()->getRouteRelationParam($attribute, $relation)) }}">
                        <i class="fa fa-trash margin-right-5"></i>{{ $component->translate('button.delete') }}
                    </a></li>
                @endcan
                </ul>
            </div>
        </div>
    @else
        <div class="col-xs-12">
            <h4 class="text-overflow margin-top-7 margin-bottom-7">{{ $component->getModel()->parent->getModelViewerComponent()->translate(sprintf('field.%s', $component->getModel()->model_attribute)) }}</h4>
        </div>
    @endif
    </div>
</div>