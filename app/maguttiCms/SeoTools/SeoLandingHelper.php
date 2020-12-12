<?php
namespace App\maguttiCms\SeoTools;

use App\City;
use App\Province;
use App\Article;
use App\maguttiCms\Website\Repos\Article\DbArticleRepository;

/**
 * SeoLandingHelper
 */
class SeoLandingHelper
{
    public function __construct()
    {
    }

    private static function collection_shuffle($array)
    {
        $keys = $array->keys()->shuffle();
        $random = collect([]);
        foreach ($keys as $_key) {
            $random[$_key] = $array[$_key];
        }
        return $random;
    }

    public static function replaceTags($string, array $tags)
    {
        foreach ($tags as $_tag => $_value) {
			if (is_array($_value)) {
				$string = str_replace('{'.$_tag.'}', $_value['base'], $string);
				if (array_key_exists('singular', $_value)) {
					$string = str_replace('{'.$_tag.'-singular}', $_value['singular'], $string);
				}
				if (array_key_exists('plural', $_value)) {
					$string = str_replace('{'.$_tag.'-plural}', $_value['plural'], $string);
				}
			} else {
				$string = str_replace('{'.$_tag.'}', $_value, $string);
			}
        }
        return $string;
    }

    public static function getLinks($setting, $count = 10, $randomize = true, Array $filters = [])
    {
        $route = config('maguttiCms.website.seolanding.'.$setting.'.route');
        $route = str_replace('/', '', $route);
        if (!$route) {
            return collect([]);
        }

        $articleRepo = new DbArticleRepository(new Article);
        $article = $articleRepo->getBySlug($setting);

        if (!$article) {
            return collect([]);
        }

        $title = $article->title;

        $compiled_links = collect([$route => $title]);

        preg_match_all('/\{([a-z]+)\}/', $route, $matches);
        // for every match, substitute the tag
        foreach ($matches[1] as $_match) {
            $_tag = '{'.$_match.'}';
            // get the possible values
            $_values = collect(config('maguttiCms.website.seolanding.'.$setting.'.'.$_match));

			if (array_key_exists($_match, $filters)) {
				$_values = $_values->only($filters[$_match]);
			}

            // for each compiled route
            for ($i=0; $i < $compiled_links->count(); $i++) {
                $_link_slug = $compiled_links->keys()[$i];
                $_link_title = $compiled_links->values()[$i];
                // perform a substitution for every possibile value
                if (strpos($_link_slug, $_tag) !== false) {
                    // if we find a route that needs to be replaced, remove it from the array
                    unset($compiled_links[$_link_slug]);
                    $i--;
                    // add routes with the replaced value
                    foreach ($_values as $_slug => $_title) {
						if (is_array($_title)) {
							$compiled_links[str_replace($_tag, $_slug, $_link_slug)] = str_replace($_tag, $_title['base'], $_link_title);
						} else {
							$compiled_links[str_replace($_tag, $_slug, $_link_slug)] = str_replace($_tag, $_title, $_link_title);
						}
                    }
                }
            }
        }

        if ($randomize) {
            $compiled_links = self::collection_shuffle($compiled_links);
        }

        if ($count) {
            $compiled_links = $compiled_links->take($count);
        }

        return $compiled_links;
    }
}
