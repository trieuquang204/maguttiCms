<aside class="mt-5 mt-md-0">
    <h5 class="text-accent">Ultime News</h5>
    @foreach ( $getLatestPost(6) as $latest_post)
        <div class="media news__sidebar">
            <a href="{{ $latest_post->getPermalink() }}">
                <img class="img-fluid mr-2"
                     src="{{ ImgHelper::get($latest_post->image,config('maguttiCms.image.small')) }}">
            </a>
            <div class="media-body news__sidebar-body">
                <small><b>{{ $latest_post->getFormattedDate() }}</b></small>
                <a class="d-block" href="{{ $latest_post->getPermalink() }}">{{ $latest_post->title }}</a>
            </div>
        </div>
    @endforeach
</aside>