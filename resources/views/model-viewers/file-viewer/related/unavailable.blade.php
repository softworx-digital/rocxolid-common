@can ('view', [ $related, $attribute ])
<div id="{{ $component->getDomId($related->getKey(), $attribute) }}" class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-sm-8 col-xs-10">
                <h4 class="text-overflow margin-top-7 margin-bottom-7">{{ $component->getModel()->parent->getModelViewerComponent()->translate(sprintf('field.%s', $attribute)) }}</h4>
            </div>
            <div class="col-sm-4 col-xs-2">
                <div class="btn-group btn-group-sm pull-right hidden-xs" role="group">
                @can ('create', [ $related, $attribute ])
                    <a
                        class="btn btn-default"
                        data-ajax-url="{{ $component->getModel()->getControllerRoute('create', $component->getModel()->getRouteRelationParam($attribute, $relation, $related)) }}">
                        <i class="fa fa-upload margin-right-5"></i>{{ $upload_button_label ?? $component->translate('button.upload') }}
                    </a>
                @endcan
                </div>

                <div class="btn-group btn-group-sm pull-right visible-xs-block">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="caret"></span></button>
                    <ul class="dropdown-menu">
                    @can ('create', [ $related, $attribute ])
                        <li><a data-ajax-url="{{ $component->getModel()->getControllerRoute('create', $component->getModel()->getRouteRelationParam($attribute, $relation, $related)) }}">
                            <i class="fa fa-upload margin-right-5"></i>{{ $upload_button_label ?? $component->translate('button.upload') }}
                        </a></li>
                    @endcan
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endcan