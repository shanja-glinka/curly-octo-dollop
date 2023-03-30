<?

namespace System\Utils;

class TimeWorker
{
	public static function timeToStamp($t = '*')
	{
		if ('' === $t)
			return '';
		if ('*' === $t)
			$t = time();

		return gmdate('YmdHis', $t);
	}

	public static function stampToTime($p)
	{
		if (empty($p))
			return null;

		$p = str_pad($p, 14, '0', STR_PAD_LEFT);
		return @gmmktime(@substr($p, 8, 2), @substr($p, 10, 2), @substr($p, 12, 2), @substr($p, 4, 2), @substr($p, 6, 2), @substr($p, 0, 4));
	}

	public static function stampToViewFormat($p)
	{
		$date = TimeWorker::stampToTime($p);
		if ($date === null)
			return '';
			
		return gmdate('Y M d H:i', $date);
	}
}
