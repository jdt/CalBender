<?php
namespace AppBundle\Entity\Value;

class Date
{
	private $year;
	private $month;
	private $day;

	public function __construct($year, $month, $day)
	{
		$this->year = $year;
		$this->month = $month;
		$this->day = $day;
	}
}