<?php

namespace App\maguttiCms\Domain\Location;

use App\Location;
use App\maguttiCms\Domain\Website\WebsiteViewModel;
use App\Tag;
use phpDocumentor\Reflection\Types\Collection;

class LocationViewModel extends WebsiteViewModel
{


    function show($slug)
    {
        $location = Location::findBySlug($slug, app()->getLocale());
        $locations = collect(Location::published()->orderBy('sort')->pluck('id'));
        $curItem  = array_search($location->id, $locations->toArray());
        $nextId = (isset($locations[$curItem+1]))?$locations[$curItem+1]:$locations->first();
        $prevId = (isset($locations[$curItem-1]))?$locations[$curItem-1]:$locations->last();
        $next   = Location::find($nextId);
        $prev   = Location::find($prevId);

        $article = $this->getCurrentPage();
        $this->setSeo($location);
        $locale_article = $location;

        return view('website.location.single', compact('article', 'location', 'locale_article','next','prev'));

    }

    function index()
    {
        $article = $this->getCurrentPage();
        $locations = Location::published()->orderBy('sort')->get();
        $this->setSeo($article);
        return view('website.location.index', ['article' => $article, 'locations' =>  $locations]);

    }

    function handle($slug)
    {
        return ($slug == '') ? $this->index() : $this->show($slug);
    }

}