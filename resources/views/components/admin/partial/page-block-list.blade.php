@if($item->blocks->count())
    <x-admin.card.side-bar id="page-block-list">
        <x-slot name="title">{!! trans('admin.label.page-blocks')!!}</x-slot>
        <ul>
            @foreach($item->blocks as $block)
                <li>
                    <a href="{{ma_get_admin_edit_url($block)}}">- {!! $block->title !!}</a>
                </li>
            @endforeach
        </ul>
    </x-admin.card.side-bar>
@endif
