<?php namespace App\maguttiCms\Tools;

use App\maguttiCms\Tools\SettingHelper;

/**
* Class Setting
* @package App\maguttiCms\Tools
*/
class HtmlHelper {
	protected $args = [];

	public function setHtmlTagAttributes($array) {
		foreach($array as $key => $value) {
			$this->args[$key] = $value;
		}
		return $this;
	}

	public function getHtmlTagAttributes() {
		return $this->args;
	}

	public function createHtmlTagAttributes() {
		$attribute_string = "";

		foreach($this->getHtmlTagAttributes() as $key => $value) {
			$attribute_string .= $key ."=\"" . $value . "\" ";
		}

		return $attribute_string;
	}

	/**
	* @param $icons
	* @param $classes
	* @param $forceicon
	* @param $echo
	* @return mixed
	*/
	public static function createFAIcon($icons, $classes = '', $force_set = '', $echo = true) {
		$arr_icons = explode(',', $icons);
		$str_classes = implode(' ',explode(',', $classes));

		$set = ($force_set)? $force_set: config('maguttiCms.website.option.icons');

		switch ($set) {
			case 'fontello':
				$output = '<i class="icon-'.$arr_icons[0].' '.$str_classes.'"></i>';
				break;
			case 'mi':
				$output = '<i class="material-icons '.$str_classes.'">'.$arr_icons[0].'</i>';
				break;
			case 'mdi':
				$output = '<i class="mdi mdi-'.$arr_icons[0].' '.$str_classes.'"></i>';
				break;
			default:
				if ((count($arr_icons) == 1)) {
					//simple icon
					$output = '<i class="fas fa-'.$arr_icons[0].' '.$str_classes.'"></i>';
				}
				else {
					//stacked icon
					$output = '';
					$output .= '<span class="fa-stack '.$str_classes.'">';
					$output .= '<i class="fas fa-'.$arr_icons[0].' fa-stack-2x"></i>';
					$output .= '<i class="fas fa-'.$arr_icons[1].' fa-stack-1x fa-inverse"></i>';
					$output .= '</span>';
				}
				break;
		}

		if ($echo) echo $output; else return $output;
	}

	public static function checkError($errors, $field) {
		if ($errors->has($field)) {
			return 'input-danger';
		}
	}

    /**
     *  Youtube  video embed
     * @param $id
     * @param string $ratio
     * @param string $extra_class
     * @return string
     */
	public static function videoEmbed($id, $ratio = '16by9',$extra_class="") {
		$output = '';
		$output .= '<div class="embed-responsive embed-responsive-'.$ratio.' '.$extra_class.'">';
        $output .= '<iframe class="embed-responsive-item" src="'.self::getYoutubeUrl($id).'" allowfullscreen></iframe>';
		$output .= '</div>';
		return $output;
	}

	// Get responsive image
	public function get_responsive($src, $args_small=['w' => 768], $args_medium=['w' => 1200]) {
		return "<picture>
		<source media='(max-width: 768px)' sizes='100vw'
		srcset='". \ImgHelper::get_cached($src, $args_small) ."'>
		<source media='(max-width: 1200px)' sizes='100vw'
		srcset='". \ImgHelper::get_cached($src, $args_medium) ."'>
		<img src='".ma_get_image_from_repository($src)."' ".$this->createHtmlTagAttributes().">
		</picture>";
	}

	/**
     * GF_ma
     * @param $text
     * @param $index
     * @return string
     */
    public  function content_part($text, $index = 0) {
        $array = preg_split('/<p><!-- pagebreak --><\/p>|<!-- pagebreak -->/', $text);
        $index = (int)$index;
	    return (sizeOf($array) > $index)? $array[$index]: '';
    }

    /**
     * GF_ma
     * @param $text
     * @return array
     */
    public  function content_part_looper($text) {
        return explode('<!-- pagebreak -->',$text);
    }

	public static function getYoutubeUrl($id)
	{
		return 'https://www.youtube-nocookie.com/embed/'.$id.'?rel=0';
	}

	public function getStaticMap($lat, $lng, $zoom = 10, $width = 512, $height = 512)
	{
		$key = SettingHelper::getOption('GMAPS_KEY');
		if ($key) {
			$base_url = 'https://maps.googleapis.com/maps/api/staticmap?center=%d,%d&zoom=%d&scale=false&size=%dx%d&maptype=roadmap&format=jpg&visual_refresh=true&markers=%d,%d&key=%s';
			return sprintf($base_url, $lat, $lng, $zoom, $width, $height, $lat, $lng, $key);
		} else {
			return 'https://via.placeholder.com/'.$width.'x'.$height;
		}
	}
}
