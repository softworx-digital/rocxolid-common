{{-- @todo hotfixed --}}
<div id="{{ $component->getDomId('dynamic-attribute-group', $component->getModel()->getKey()) }}" class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">{{ $component->getModel()->getTitle() }}</h3>
    </div>
    <div class="panel-body">
        <dl class="dl-horizontal">
        @foreach ($component->getModel()->attributes as $attribute)
            <dt>{{ $attribute->getTitle() }}</dt>
            <dd>
            @if ($attribute->isType('boolean'))
                @if ($attributable->derivedAttributeValue($attribute))
                    <i class="fa fa-check text-success"></i>
                    @if ($attributable->isOptionalDerivedAttribute($attribute))
                    <i class="fa fa-question text-success"></i>
                    @endif
                @else
                    <i class="fa fa-close text-danger"></i>
                @endif
            @else
                {!! $attributable->derivedAttributeValue($attribute) !!}
            @endif
            </dd>
        @endforeach
        </dl>
    </div>
</div>