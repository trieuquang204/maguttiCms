<div {{ $attributes->merge(['class' => 'page-share']) }}>
    <span class="page-share__label">{{ trans('website.news.share_on') }}</span>
    <a href="https://www.facebook.com/sharer.php?u={{ $item->getPermalink() }}" title="Facebook" target="_blank">
        <span class="fa-stack">
            <i class="fas fa-circle fa-stack-2x"></i>
            <i class="fab fa-facebook fa-stack-1x fa-inverse"></i>
        </span>
    </a>
    <a href="mailto:?subject={{ $item->title }}&body={{ $item->getPermalink() }}" title="Email">
        <span class="fa-stack">
            <i class="fa fa-circle fa-stack-2x"></i>
            <i class="fas fa-envelope fa-stack-1x fa-inverse"></i>
        </span>
    </a>
</div>