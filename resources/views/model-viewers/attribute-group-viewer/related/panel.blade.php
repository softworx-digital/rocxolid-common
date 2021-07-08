<div id="{{ $component->getDomId('dynamic-attribute-group', $component->getModel()->getKey()) }}" class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">
            {{ $component->getModel()->getTitle() }}
        @if (!($read_only ?? false) && $user->can('update', $component->getModel()))
            <a data-ajax-url="{{ $attributable->getControllerRoute('modelAttributes', [ 'attribute_group' => $component->getModel() ]) }}" class="pull-right margin-left-5"><i class="fa fa-pencil"></i></a>
        @endcan
        </h3>
    </div>
    <div class="panel-body">
        <dl class="dl-horizontal">
        @foreach ($component->getModel()->attributes as $attribute)
            <dt>{{ $attribute->getTitle() }}</dt>
            <dd>
            @if ($attribute->isType('boolean'))
                @if ($attributable->attributeValue($attribute))
                    <i class="fa fa-check text-success"></i>
                @else
                    <i class="fa fa-close text-danger"></i>
                @endif
            @else
                {!! $attributable->attributeValue($attribute) !!}
            @endif
            </dd>
        @endforeach
        </dl>
    </div>
</div>