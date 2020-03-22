<div class="panel-heading">
    <div class="row">
        <div class="col-xs-12">
            <div class="btn-group btn-group-sm center-block hidden-xs pull-right" role="group">
            @can ('create', [ $component->getModel()->$relation, $attribute ])
                <a
                    class="btn btn-default"
                    data-ajax-url="{{ $component->getModel()->getControllerRoute('create', $component->getModel()->getRouteRelationParam($attribute, $relation, $component->getModel()->$relation)) }}">
                    <i class="fa fa-upload margin-right-5"></i>{{ $component->translate('button.upload-image') }}
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
                </ul>
            </div>
        </div>
    </div>
</div>