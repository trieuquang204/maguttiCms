


        <li>{{ $child_article->title }} </li>
        @if ($articles->where('parent_id', $child_article->id))
            <ul>
                @foreach ($articles->where('parent_id', $child_article->id) as $child)
                    @include('website/tree/small_tree', ['child_article' => $child])
                @endforeach
            </ul>
        @endif
