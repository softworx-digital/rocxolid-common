<div id="{{ $component->getDomId('attributes') }}" class="row">
    <div class="col-xs-12 table-responsive">
        <div class="panel panel-default">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>{{ __('rocXolid::attribute.field.name') }}</th>
                        <th class="text-center">{{ __('rocXolid::attribute.field.type') }}</th>
                    @if (false)
                        <th class="text-center">{{ __('rocXolid::attribute.field.is_multiple') }}</th>
                    @endif
                        <th class="text-center">{{ __('rocXolid::attribute.field.description') }}</th>
                        <th class="text-center">{{ __('rocXolid::attribute.field.note') }}</th>
                        <th class="text-center">{{ __('rocXolid::attribute.field.values') }}</th>
                    @if ((!isset($ro) || !$ro) && $component->getModel()->userCan('write'))
                        <th class="text-right" style="min-width: 90px;">
                            <button class="btn btn-primary btn-sm col-xs-12" data-ajax-url="{{ $component->getModel()->attributes()->getRelated()->getControllerRoute('create', [ '_section' => 'attributes', '_data[attribute_group_id]' => $component->getModel()->getKey() ]) }}" title="{{ __('rocXolid::attribute.table-button.add') }}"><i class="fa fa-plus"></i></button>
                        </th>
                    @endif
                    </tr>
                </thead>
                <tbody class="sortable ajax-overlay" data-update-url="{{ $component->getModel()->getControllerRoute('reorder', [ 'relation' => 'attributes' ]) }}">
                @foreach ($component->getModel()->attributes as $attribute)
                    <tr data-item-id="{{ $attribute->getKey() }}">
                        <td>{{ $attribute->name }}</td>
                        <td class="text-center">{{ __(sprintf('rocXolid::attribute.type-choices.%s', $attribute->type)) }}</td>
                    @if (false)
                        <td class="text-center"><div class="text-center">
                            @if ($attribute->is_multiple)
                                <i class="fa fa-check-square-o text-success fa-2x"></i>
                            @else
                                <i class="fa fa-square text-muted fa-2x"></i>
                            @endif
                        </div></td>
                    @endif
                        <td class="text-center">{{ $attribute->description }}</td>
                        <td class="text-center">{{ $attribute->note }}</td>
                        <td class="text-center">
                        @if ($attribute->isType('enum'))
                            @foreach ($attribute->attributeValues as $attribute_value)
                                <span class="label label-info">{!! $attribute_value->getTitle() !!}</span>
                            @endforeach
                        @else
                            {{ __(sprintf('rocXolid::attribute.type-values.%s', $attribute->type)) }}
                        @endif
                        </td>
                    @if ((!isset($ro) || !$ro) && $component->getModel()->userCan('write'))
                        <td class="text-right">
                            <div class="btn-group">
                            @if ($attribute->isType('enum'))
                                <button data-ajax-url="{{ $attribute->getControllerRoute('setValues') }}" class="btn btn-success btn-sm margin-right-no" title="{{ __('rocXolid::attribute.table-button.set-values') }}"><i class="fa fa-list"></i></button>
                            @endif
                                <button data-ajax-url="{{ $attribute->getControllerRoute('edit', ['_section' => 'attributes']) }}" class="btn btn-info btn-sm margin-right-no" title="{{ __('rocXolid::attribute.table-button.edit') }}"><i class="fa fa-pencil"></i></button>
                                <span class="btn btn-default btn-sm margin-right-no drag-handle"><i class="fa fa-arrows"></i></span>
                                <button data-ajax-url="{{ $attribute->getControllerRoute('destroyConfirm') }}" class="btn btn-danger btn-sm margin-right-no" title="{{ __('rocXolid::attribute.table-button.delete') }}"><i class="fa fa-trash"></i></button>
                            </div>
                        </td>
                    @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>