<h1 class="mb-0">
    @if ($article!='')
        @if ($article->title!='')
            {{trans('admin.label.edit')}} <strong>{{ $article->title }}</strong>
        @elseif( $article->name!='')
            {{trans('admin.label.edit')}} <strong>{{ $article->name }}</strong>
        @endif
    @else
        {{trans('admin.models.'.$model)}}
    @endif
 </h1>

