@props([
    'class'=>'bg-accent',
    'title'=>''
])
<x-website.ui.breadcrumbs class="{{$class??'bg-accent'}}">
    <div class="text-white page-breadcrumb d-flex align-items-end">
        <h1 class="page-breadcrumb__item">{{$title}}</h1>
    </div>
</x-website.ui.breadcrumbs>

