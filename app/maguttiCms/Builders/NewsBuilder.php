<?php

namespace App\maguttiCms\Builders;

use App\News;
use Carbon\Carbon;

class NewsBuilder extends MaguttiCmsBuilder
{
    /**
     * @param int $limit
     * @return mixed
     */
    public function latestPublished($limit = 5)
    {
        return $this->published()->translatedContent()->latest('date')->limit($limit);
    }

    /**
     * @return MaguttiCmsBuilder|NewsBuilder
     */
    public function published()
    {
        return $this->where('pub', 1)->where('date', '<=', Carbon::now());
    }
    /*
     *
     */
    function findPublished()
    {
        return $this->published()->latest('date');
    }

    /**
     * @param $tag
     * @return NewsBuilder|\Illuminate\Database\Eloquent\Builder
     */
    function findByTag($tag)
    {
        return $this->whereHas('tags', function ($query) use ($tag) {
                    $query->where('slug', 'like', '%' . $tag . '%');
        });
    }


    function itemList($tag,$limit=null){
        $limit ?? config('maguttiCms.website.option.pagination.news_index');
        return $this->findPublished()
            ->when($tag, function ($query, $tag) {
                return $query->findByTag($tag);
            })->paginate($limit);
    }


}
