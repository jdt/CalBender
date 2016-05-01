<?php
namespace AppBundle\Repository;

use \DateTime;

interface ICalDavServer
{
	function selectEvents(DateTime $from, DateTime $to);
}