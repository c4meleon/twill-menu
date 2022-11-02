@php
    $type = $block->input('item_type');
@endphp

<div class="mb-10">
    <ul>
        <li>
            <a> {{ $type == 'external' ?  $block->translatedinput('menu_external_label') : $block->translatedinput('menu_internal_label') }} </a>
            @if(count($block->children) > 0)
                <ul style="margin-left:100px;">
                @foreach($block->children as $child)
                @php
                    $child_type = $child->input('item_type');
                @endphp
                    <li>
                        <a> {{ $child_type == 'external' ?  $child->translatedinput('menu_external_label') : $child->translatedinput('menu_internal_label') }} </a>
                    </li>
                @endforeach
                </ul>
            @endif
        </li>
    </ul>
</div>





