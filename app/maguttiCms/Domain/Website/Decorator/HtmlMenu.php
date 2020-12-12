<?php

namespace App\maguttiCms\Domain\Website\Decorator;

use Auth;
use LaravelLocalization;

use StoreHelper;
use App\maguttiCms\Website\Decorator\maguttiCmsDecorator;
use App\Article;
use App\Social;

/**
 * Class HtmlMenu
 * @package App\maguttiCms\Website\Decorator
 */
class HtmlMenu extends maguttiCmsDecorator
{
	/**
	 * This method is used to get the articles links html.
	 */
	public static function getArticlesLinks($current_page)
	{
		$html = '';

		$menu = Article::menuItems()->get();
		$top = $menu->where('parent_id', 0);

		foreach ($top as $index => $page) {
			$children = $menu->where('parent_id', $page->id) ;
			$active = (!empty($current_page) && ($current_page->id == $page->id || $current_page->parent_id == $page->id)) ? 'active' : '';

			if (optional($children)->count() > 0) {
				$html .= view('website.navbar.dropdown', compact('page', 'children', 'active'));
			} else {
				$html .= view('website.navbar.item', compact('page', 'active'));
			}
		}

		return $html;
	}

	/**
	 * This method is used to get the auth links html.
	 */
	public static function getAuthLinks()
	{
		return view('website.navbar.auth');
	}

	/**
	 * This method is used to get the store links html.
	 */
	public static function getStoreLinks()
	{
		if (StoreHelper::isStoreEnabled()) {
			return view('website.navbar.store');
		}
	}

	/**
	 * This method is used to get the language selector html.
	 */
	public static function getLanguageSelector($locale_article)
	{
		if (count(LaravelLocalization::getSupportedLocales()) > 1) {
			return view('website.navbar.language_selector', compact('locale_article'));
		}
	}

	public static function getSocial()
	{
		$socials = Social::published()->orderBy('sort')->get();
		return view('website.navbar.social', compact('socials'));
	}

	public static function getBeforeNavbar()
	{
		return view('website.navbar.before');
	}

	public static function getAfterNavbar()
	{
		return view('website.navbar.after');
	}
}
