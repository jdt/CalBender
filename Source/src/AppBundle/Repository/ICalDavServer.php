<?php
namespace AppBundle\Repository;

interface ICalDavServer
{
	function getEvents(DateTime $from, DateTime $to);
}