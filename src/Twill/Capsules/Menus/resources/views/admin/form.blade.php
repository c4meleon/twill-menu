@extends('twill::layouts.form', [
    'contentFieldsetLabel' => 'Settings',
    'revisions' => [],
    'additionalFieldsets' => [
        ['fieldset' => 'media', 'label' => 'Media'],
    ],
    'sideFieldsetLabel' => 'Settings'
])

@section('contentFields')
@php  $positions=config('twill-menu.menu_positions'); @endphp

    @formField('select', [
    'name' => 'location',
    'label' => 'Location',
    'placeholder' => 'Select menu position',
    'options' =>  $positions])

    @formField('checkbox', [
    'name' => 'default',
    'label' => 'Default'
    ])

@stop

@section('fieldsets')

    <a17-fieldset title="Menu" id="menu" :open="true">

        @formField('block_editor', [
        'label' => 'Add to menu',
        'blocks' => ['menu']
        ])

    </a17-fieldset>
@endsection
