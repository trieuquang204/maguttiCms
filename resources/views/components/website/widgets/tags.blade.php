@unless($news->tags->isEmpty())
    <ul class="tags list-inline">
        @foreach ( $news->tags as $item )
            <li class="list-inline-item tags-item">
                <a href="tags/{{ $item->slug }}" target="_new" class="badge tags-badge bg-color-4">{{ $item->title }} </a>
            </li>
        @endforeach
    </ul>
@endunless
