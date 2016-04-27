<?php
namespace AppBundle\Repository;

use AppBundle\Entity\Value\Date;

interface IEventRepository
{
	function selectEvents(Date $from, Date $to);
}