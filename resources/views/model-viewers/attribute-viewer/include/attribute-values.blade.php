<div id="{{ $component->makeDomId('attribute-values') }}" class="row">
    <div class="col-xs-12 table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>{{ __('rocXolid::attribute-value.field.name') }}</th>
                    <th class="text-center">{{ __('rocXolid::attribute-value.field.description') }}</th>
                    <th class="text-center">{{ __('rocXolid::attribute-value.field.note') }}</th>
                @if ((!isset($ro) || !$ro) && $component->getModel()->userCan('write'))
                    <th class="text-right" style="min-width: 90px;">
                        <button class="btn btn-primary btn-sm col-xs-12" data-ajax-url="{{ $component->getModel()->attributeValues()->getRelated()->getControllerRoute('create', [ '_section' => 'attribute-values', '_data[attribute_id]' => $component->getModel()->id ]) }}" title="{{ __('rocXolid::attribute-value.table-button.add') }}"><i class="fa fa-plus"></i></button>
                    </th>
                @endif
                </tr>
            </thead>
            <tbody class="sortable vertical ajax-overlay">
            @foreach ($component->getModel()->attributeValues as $attribute_value)
                <tr>
                    <td>{!! $attribute_value->name !!}</td>
                    <td class="text-center">{{ $attribute_value->description }}</td>
                    <td class="text-center">{{ $attribute_value->note }}</td>
                @if ((!isset($ro) || !$ro) && $component->getModel()->userCan('write'))
                    <td class="text-right">
                        <div class="btn-group">
                            <!--<span class="btn btn-default btn-sm margin-right-no drag-handle"><i class="fa fa-arrows"></i></span>-->
                            <button data-ajax-url="{{ $attribute_value->getControllerRoute('edit', ['_section' => 'attribute-values']) }}" class="btn btn-info btn-sm margin-right-no" title="{{ __('rocXolid::attribute-value.table-button.edit') }}"><i class="fa fa-pencil"></i></button>
                            <button data-ajax-url="{{ $attribute_value->getControllerRoute('destroyConfirm') }}" class="btn btn-danger btn-sm margin-right-no" title="{{ __('rocXolid::attribute-value.table-button.delete') }}"><i class="fa fa-trash"></i></button>
                        </div>
                    </td>
                @endif
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>