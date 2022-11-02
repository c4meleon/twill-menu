@twillBlockTitle('Menu item')
@twillBlockIcon('wysiwyg_link')
@twillPropIcon('wysiwyg_link')
@twillRepeaterIcon('wysiwyg_link')

@formField('select', [
'name' => "item_type",
'label' => "Type link",
'native' => true,
'placeholder' => 'Select link',
'options' => [
[
'value' => 'internal',
'label' => 'Internal link'
],
[
'value' => 'external',
'label' => 'External link'
]
],
])

<!--if selected is link-->
@formConnectedFields([
'fieldName' => 'item_type',
'fieldValues' => 'external',
'renderForBlocks' => true
])

<x-formColumns>
    <x-slot name="left">
        @formField('input', [
        'name' => 'menu_external_link',
        'label' => 'URL',
        'placeholder' => 'https://www.example.com',
        'translated' => true,
        'maxlength' => 500,
        ])

    </x-slot>
    <x-slot name="right">
        @formField('input', [
        'name' => 'menu_external_label',
        'label' => 'Label',
        'translated' => true,
        'maxlength' => isset($maxCtaLabel) ? $maxCtaLabel : 30,
        'placeholder' => 'Link name',
        ])
    </x-slot>
</x-formColumns>

@endformConnectedFields

@php  $moduls=config('twill-menu.menu_modules'); @endphp
    <!--if selected is page or news-->
@formConnectedFields([
'fieldName' => 'item_type',
'fieldValues' => 'internal',
'renderForBlocks' => true
])

<x-formColumns>
    <x-slot name="left">
        @if($moduls)
            @formField('browser', [
            'modules' => $moduls,
            'name' => 'menu_internal_link',
            'label' => 'Internal link',
            'max' => 1,
            'min' => 1
            ])
        @endif
    </x-slot>
    <x-slot name="right">
        @formField('input', [
        'name' => 'menu_internal_label',
        'label' => 'Label',
        'translated' => true,
        'default' => 'Custom Link',

        ])
    </x-slot>
</x-formColumns>

@endformConnectedFields


<x-formColumns>
    <x-slot name="left">
       @formField('checkbox', [
        'name' => 'target',
        'label' => 'Open link in a new window?',
        'default' => false
    ])

        @formField('checkbox', [
        'name' => 'outlined',
        'label' => 'Outlined',
        'default' => false
    ])
    </x-slot>
    <x-slot name="right">
        @formField('input', [
        'name' => 'extra_class',
        'label' => 'Extra Class',
        ])
    </x-slot>
</x-formColumns>

@formField('repeater', [
'type' => 'menu-item'
])
