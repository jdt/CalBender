<?php
namespace AppBundle\Controller;

interface IResponseBuilder
{
	public function asJson(array $data);
}