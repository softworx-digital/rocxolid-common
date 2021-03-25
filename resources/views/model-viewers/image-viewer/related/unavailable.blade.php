@can ('view', [ $related, $attribute ])
<div id="{{ $component->getDomId(md5(get_class($related)), $related->getKey(), $attribute) }}" class="panel panel-default">
    {!! $component->render('related.panel-heading', [
        'relation' => $relation,
        'attribute' => $attribute,
        'read_only' => $read_only ?? false,
    ]) !!}
    <div class="panel-body text-center text-primary">
        {{ Html::image(sprintf('vendor/softworx/rocXolid/images/%s.svg', $placeholder ?? $component->getModel()->{$relation}()->getRelated()->getImagePlaceholder() ?? 'placeholder'), $attribute, [ 'style' => 'max-width: 100%; padding: 3em;' ]) }}
    </div>
    @if (!($read_only ?? false))
    <div class="panel-footer">
        <div class="row">
            <div class="col-xs-12">
                <div class="btn-group btn-group-sm center-block hidden-xs" role="group">
                @can ('create', [ $related, $attribute ])
                    <a
                        class="btn btn-default"
                        data-ajax-url="{{ $component->getModel()->getControllerRoute('create', $component->getModel()->getRouteRelationParam($attribute, $relation, $related)) }}">
                        <i class="fa fa-upload margin-right-5"></i>{{ $component->translate('button.upload-image') }}
                    </a>
                @endcan
                </div>

                <div class="btn-group btn-group-sm pull-right visible-xs-block">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
                    <ul class="dropdown-menu">
                    @can ('create', [ $related, $attribute ])
                        <li><a data-ajax-url="{{ $component->getModel()->getControllerRoute('create', $component->getModel()->getRouteRelationParam($attribute, $relation, $related)) }}">
                            <i class="fa fa-upload margin-right-5"></i>{{ $component->translate('button.upload-image') }}
                        </a></li>
                    @endcan
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endcan