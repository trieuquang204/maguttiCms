<?php namespace App\maguttiCms\Tools;
class Tool {

	//********************* PASSWORD AND TOKEN ********************************************/

    /**
     * @param int $length
     * @param bool $use_lowercase
     * @param bool $use_uppercase
     * @param bool $use_numbers
     * @param bool $use_specials
     * @return string
     * @throws \Exception
     */
	public static function generatePassword($length = 10, $use_lowercase = true, $use_uppercase = true, $use_numbers = true, $use_specials = true)
	{
		$letters = 'abcdefghijklmnopqrstuvwxyz';
		$numbers = '0123456789';
		$specials = '!?$*#^-_~()[]{}.,:;<>&%@';

		$dictionary = '';

		$pass = '';
		// required characters and compile full dictionary
		if ($use_lowercase) {
			$pass .= $letters[random_int(0, strlen($letters) - 1)];
			$dictionary .= $letters;
		}
		if ($use_uppercase) {
			$pass .= strtoupper($letters[random_int(0, strlen($letters) - 1)]);
			$dictionary .= strtoupper($letters);
		}
		if ($use_numbers) {
			$pass .= $numbers[random_int(0, strlen($numbers) - 1)];
			$dictionary .= $numbers;
		}
		if ($use_specials) {
			$pass .= $specials[random_int(0, strlen($specials) - 1)];
			$dictionary .= $specials;
		}

		// complete the password
		for ($i = strlen($pass); $i < $length; $i++)
			$pass .= $dictionary[random_int(0, strlen($dictionary) - 1)];
		return $pass;

		// shuffle the result
		$pass = str_shuffle($pass);
		return $pass;
	}

	public  static function encodePassword($password){
	    	return $pwd = md5($password);
	}

	public static function generateToken() {
       return md5(uniqid(rand(), true));
    }

	/******************************** SEO E GESTIONE PAGINE URL ********************/


	/**
	* url della  pagina ma_curPageURL
	*
	*
	* @return string $pageURL
	*/
	function ma_curPageURL() {
		$pageURL = 'http';
		if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
		$pageURL .= "://";
		if ($_SERVER["SERVER_PORT"] != "80") {
			$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		}
		else {
			$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		}
		return $pageURL;
	}


    /**
	* return check   URL is  in the  current domain
	* @param  string $url
	* @param  string $target (OPTIONAL - DEFAULT = new )
	* @return string
	*/
	function ma_url_target($url, $target='_new'){

		$curHost = parse_url(HTTP_SERVER);
		$linkHost= parse_url($url);
		if($curHost['host']== $linkHost['host']) return '';
		else return " target=\"".$target."\" ";

	}
	 /**
	* return check   URL is a  vaild  url
	* @param  string $str
	*
	* @return string  $str
	*/
	function ma_prep_url( $str = ''){
		if ($str == 'http://' OR $str == '')
		{
			return '';
		}

		if (substr($str, 0, 7) != 'http://' && substr($str, 0, 8) != 'https://')
		{
			$str = 'http://'.$str;
		}

		return $str;
	}

	/********************************  LANG  HANDLER  ********************/
    /**
	* return init  the  website language
	* @param  string $defaultLang
	*
	* @return string $lang
	*/
	public static function comefrom( $defaultLang) {
		$lang = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
		if (substr($lang, 0, 2) == 'en'){
			$lang='en';
		}
		else if (substr($lang, 0, 2) == 'it'){
			$lang='it';
		}
		else $lang=$defaultLang;
	    return $lang;
	}

	 /**
	* return the bowser lang
	*
	*
	* @return string
	*/
	function browserLang()
	{
		if (preg_match('/zh-tw/i', $_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
			return "zh-TW";
		} else {
			return substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
		}
	}

}
