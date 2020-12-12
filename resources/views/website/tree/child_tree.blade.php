@php $level++ @endphp
<li>{{ $child_category->title }}</li>
@if ($child_category->articles)
    <ul>
        @foreach ($child_category->articles as $childCategory)
            @include('website/tree/child_tree', ['child_category' => $childCategory])
        @endforeach
    </ul>
@endif
