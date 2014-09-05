<?php

class EventsUtil
{

	public static function h($s)
	{
		return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
	}

	public static function pluralise($s)
	{
		if (preg_match("/y$/", $s)) {
			return preg_replace('/y$/', 'ies', $s);
		}
		if (preg_match("/s$/", $s)) {
			return preg_replace('/s$/', 'es', $s);
		}
		return $s . 's';
	}

	public static function truncate($s, $length = 20)
	{
		if (strlen($s) <= $length) {
			return $s;
		}
		return substr($s, 0, $length) . '...';
	}

	public static function format_date($date, $inc_time = false)
	{
		if ($date == '0000-00-00 00:00:00') {
			return null;
		}
		if (!is_numeric($date)) {
			$date = strtotime($date);
		}
		if ($inc_time) {
			return date('Y-m-d H:i', $date);
		}
		return date('Y-m-d', $date);
	}

	public static function format_currency($amount)
	{
		static $locale_money = null;
		if (is_null($locale_money)) {
			$lc = localeconv();
			if (!$lc['currency_symbol']) {
				// Default to something with a dollar sign.
				setlocale(LC_MONETARY, 'en_US', 'en_US.UTF8', 'en_US.UTF-8');
			}
			$locale_money = 1;
		}
		if (!$amount) {
			return null;
		}
		return money_format('%n', $amount);
	}

	public static function image($file)
	{
		return self::public_path() . '/images/' . $file;
	}

	public static function css($file)
	{
		$href = self::public_path() . '/css/' . $file . '.css';
		return "<link rel=\"stylesheet\" type=\"text/css\" media=\"screen\" href=\"{$href}\" />\n";
	}
	
	private static function public_path()
	{
		return '/' . basename(CORE_ROOT) . '/plugins/events';
	}

}

// Make some aliases here to improve code readability.
// Hopefully it doesn't cause clashes.

function h($s) {
	return EventsUtil::h($s);
}

function pluralise($s) {
	return EventsUtil::pluralise($s);
}

function trunc($s, $length = 20) {
	return EventsUtil::truncate($s, $length);
}
