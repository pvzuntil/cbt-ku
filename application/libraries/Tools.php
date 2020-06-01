<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tools
{
	function indonesian_date($timestamp = '', $date_format = 'l, j F Y | H:i', $suffix = 'WIB')
	{
		if (trim($timestamp) == '') {
			$timestamp = time();
		} elseif (!ctype_digit($timestamp)) {
			$timestamp = strtotime($timestamp);
		}
		# remove S (st,nd,rd,th) there are no such things in indonesia :p
		$date_format = preg_replace("/S/", "", $date_format);
		$pattern = array(
			'/Mon[^day]/', '/Tue[^sday]/', '/Wed[^nesday]/', '/Thu[^rsday]/',
			'/Fri[^day]/', '/Sat[^urday]/', '/Sun[^day]/', '/Monday/', '/Tuesday/',
			'/Wednesday/', '/Thursday/', '/Friday/', '/Saturday/', '/Sunday/',
			'/Jan[^uary]/', '/Feb[^ruary]/', '/Mar[^ch]/', '/Apr[^il]/', '/May/',
			'/Jun[^e]/', '/Jul[^y]/', '/Aug[^ust]/', '/Sep[^tember]/', '/Oct[^ober]/',
			'/Nov[^ember]/', '/Dec[^ember]/', '/January/', '/February/', '/March/',
			'/April/', '/June/', '/July/', '/August/', '/September/', '/October/',
			'/November/', '/December/',
		);
		$replace = array(
			'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min',
			'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu',
			'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des',
			'Januari', 'Februari', 'Maret', 'April', 'Juni', 'Juli', 'Agustus', 'Sepember',
			'Oktober', 'November', 'Desember',
		);
		$date = date($date_format, $timestamp);
		$date = preg_replace($pattern, $replace, $date);
		$date = "{$date} {$suffix}";
		return $date;
	}

	function getAlpha($index)
	{
		$alpha = $this->createColumnsArray('ZZ');

		return $alpha[$index];
	}

	function createColumnsArray($end_column, $first_letters = '')
	{
		$columns = array();
		$length = strlen($end_column);
		$letters = range('A', 'Z');

		// Iterate over 26 letters.
		foreach ($letters as $letter) {
			// Paste the $first_letters before the next.
			$column = $first_letters . $letter;

			// Add the column to the final array.
			$columns[] = $column;

			// If it was the end column that was added, return the columns.
			if ($column == $end_column)
				return $columns;
		}

		// Add the column children.
		foreach ($columns as $column) {
			// Don't itterate if the $end_column was already set in a previous itteration.
			// Stop iterating if you've reached the maximum character length.
			if (!in_array($end_column, $columns) && strlen($column) < $length) {
				$new_columns = $this->createColumnsArray($end_column, $column);
				// Merge the new columns which were created with the final columns array.
				$columns = array_merge($columns, $new_columns);
			}
		}

		return $columns;
	}
}
