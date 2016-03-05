<?php
namespace AppBundle\Controller\Api;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class EventController
{
    public function indexAction(Request $request)
    {
        return new Response('<html><body>Hello!</body></html>');
    }
}
